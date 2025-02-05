<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        code {
            display: block;
            word-wrap: break-word;
            max-width: 100%;
            overflow-x: auto;
        }

    </style>
    <title>Login - Sistem</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card p-4" style="width: 300px;">
            @yield('content')
        </div>
    </div>
</body>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const copyButton = document.getElementById('copy-btn');
        const codeContent = document.getElementById('code-content').innerText;

        copyButton.addEventListener('click', () => {
            navigator.clipboard.writeText(codeContent).then(() => {
                copyButton.textContent = 'Copiado!';
                setTimeout(() => {
                    copyButton.textContent = 'Copiar';
                }, 2000);
            }).catch((err) => {
                console.error('Erro ao copiar texto: ', err);
            });
        });
    });
    </script>
</html>
