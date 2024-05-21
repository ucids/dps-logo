<!-- Create a form and then use app/create_user.php to process the form inputs -->
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.7.1.js"></script>
<form action="">
    <input type="text" id="username" name="username" placeholder="Username">
    <input type="password" id="password" name="password" placeholder="Password">
    <input type="text" id="email" name="email" placeholder="Email">
    <button id="submit">Submit</button>
</form>

<script>
    // use native fetch and async await to submit the form
    const form = document.querySelector('form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        try {
            const response = await fetch('../app/create_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseData = await response.json();
            console.log(responseData);
        } catch (error) {
            console.error('There was a problem with the fetch operation: ', error);
        }
    });
</script>