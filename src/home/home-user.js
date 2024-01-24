function routeToClipboard(clipboardId, ...types) {
    
}

async function subscribe(user_id, clipboard_id) {
    let formData = new FormData();
    formData.append("user_id", user_id)
    formData.append("clipboard_id", clipboard_id);

    console.log(user_id, clipboard_id);
    await fetch("../../src/add_user_to_clipboard.php", {
        method: "POST",
        body: formData
    });
}