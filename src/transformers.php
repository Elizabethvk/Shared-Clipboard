<?php

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

// class PhpTransformer extends Transformer
// {
//     // taken from http://php.adamharvey.name/manual/en/function.eval.php#121190
//     private function betterEval($code)
//     {
//         $tmp = tmpfile();
//         $tmpf = stream_get_meta_data($tmp);
//         $tmpf = $tmpf['uri'];
//         fwrite($tmp, $code);
//         $ret = include($tmpf);
//         fclose($tmp);
//         return $ret;
//     }

//     public function transform($clip)
//     {
//         if (!$this->canTransformFrom($clip['resource_type'])) {
//             return null;
//         }
//         // TODO Tsvetelin : check for <?php tags

//         return $this->betterEval($clip['resource_data']);
//     }

//     public function canTransformFrom($clipType)
//     {
//         return $clipType === 'php';
//     }
// public function canTransformTo()
// {
//     return ["Follow link"];
// }
// }

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

class CopyTransformer extends Transformer
{
    public function transform($clip)
    {
        // TODO Tsvetelin : copy content
    }

    public function canTransformFrom($clipType)
    {
        return true;
    }

    public function canTransformTo()
    {
        return "Copy content";
    }
}

$transformers = [new LinkTransformer(), new CopyTransformer()];

function availableTransformersFor($clipType)
{
    global $transformers;
    return array_filter($transformers, function ($transformer) use ($clipType) {
        return $transformer->canTransformFrom($clipType);
    });
}