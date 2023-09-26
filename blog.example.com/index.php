<html lang="en">
<body>
    <script>
        async function testCors() {
            const response = await fetch('http://cakefest2023.com:8765/users/index');
            document.querySelector('body').innerHTML = await response.text();
        }
        testCors();
    </script>
</body>
</html>
