document.querySelectorAll(".result", (e) => {
    const data = { username: 'example' };
    const inputData = document.getElementById("Inputbox").value;

    fetch('article.php', {
            method: 'POST', // or 'PUT'
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(inputData),
        })
        .then(response => response.json())
        .then(data => {

            // Här får ni tillbaka er data

            console.log('Success:', data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
});