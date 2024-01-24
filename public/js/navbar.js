async function logout() {
    let response = await fetch("../../src/logout.php", {
        method: "POST"
    });

    console.log(response);
}