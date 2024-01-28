<?php

function redirectBack()
{
    $previousPage = $_SERVER['HTTP_REFERER'];
    header("Location: $previousPage");
}

class Transformer
{
    public function transform($clip)
    {
    }

    public function canTransformFrom($clipType)
    {
    }

    public function canTransformTo()
    {
    }
}

class PhpTransformer extends Transformer
{
    // taken from http://php.adamharvey.name/manual/en/function.eval.php#121190
    private function betterEval($code)
    {
        $tmp = tmpfile();
        $tmpf = stream_get_meta_data($tmp);
        $tmpf = $tmpf['uri'];
        fwrite($tmp, $code);
        $ret = include($tmpf);
        fclose($tmp);
        return $ret;
    }

    public function transform($clip)
    {
        if (!$this->canTransformFrom($clip['resource_type'])) {
            return null;
        }

        $trimmed = trim($clip['resource_data']);
        if (strpos($trimmed, '<?php') !== 0) {
            $trimmed = "<?php $trimmed ?>";
        }

        return $this->betterEval($trimmed);
    }

    public function canTransformFrom($clipType)
    {
        return $clipType === 'php';
    }
    public function canTransformTo()
    {
        return "Run code";
    }
}

class LinkTransformer extends Transformer
{
    public function transform($clip)
    {
        if (!$this->canTransformFrom($clip['resource_type'])) {
            return null;
        }
        header("Location:$clip[resource_data]");
    }

    public function canTransformFrom($clipType)
    {
        return $clipType === 'link';
    }

    public function canTransformTo()
    {
        return "Follow link";
    }
}

class FileDownloadOverLinkTransformer extends Transformer
{
    public function transform($clip)
    {
        if (!$this->canTransformFrom($clip['resource_type'])) {
            return null;
        }

        $file_url = "$clip[resource_data]";

        $file_extension = pathinfo($file_url, PATHINFO_EXTENSION);
        
        $content_type = mime_content_type($file_extension);
        header("Content-Type: $content_type");

        // Without the extension (old version)
        // header('Content-Type: application/octet-stream');
        // header("Content-Transfer-Encoding: Binary");

        header("Content-disposition: attachment; filename=\"$clip[name].$file_extension\"");
        readfile($file_url);
    }

    public function canTransformFrom($clipType)
    {
        return $clipType === 'link';
    }

    public function canTransformTo()
    {
        return "Download pointed file";
    }
}

class CopyTransformer extends Transformer
{
    public function transform($clip)
    {
        echo htmlspecialchars($clip['resource_data']);
    }

    public function canTransformFrom($clipType)
    {
        return true;
    }

    public function canTransformTo()
    {
        return "Copy raw content";
    }
}

class BashTransformer extends Transformer
{
    public function transform($clip)
    {
        if (!$this->canTransformFrom($clip['resource_type'])) {
            return null;
        }
        
        exec($clip['resource_data'], $output);
        echo implode(PHP_EOL, $output);
    }

    public function canTransformFrom($clipType)
    {
        return $clipType === 'bash';
    }

    public function canTransformTo()
    {
        return "Run bash script";
    }
}

$transformers = [
    new LinkTransformer(),
    new FileDownloadOverLinkTransformer(),

    new CopyTransformer(),
];

$dangerousTransformers = [
    new PhpTransformer(),
    new BashTransformer(),
];

if($config['transformers']['enableDangerous'])
{
    $transformers = array_merge($transformers, $dangerousTransformers);
}

function availableTransformersFor($clipType)
{
    global $transformers;
    return array_filter($transformers, function ($transformer) use ($clipType) {
        return $transformer->canTransformFrom($clipType);
    });
}