<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400&family=Berkshire+Swash&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6c26bb, #0a073b);
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            font-family: 'Comfortaa', sans-serif;
        }

        .title {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 4rem;
            font-family: 'Berkshire Swash', cursive;
            color: white;
        }

        .login-container {
            width: 80%;
            max-width: 600px;
            padding: 3rem;
            background-color: rgba(28, 7, 54, 0.9);
            border-radius: 0.5rem;
            box-shadow: 0 4px 20px rgba(176, 162, 255, 0.5);
            position: relative;
            z-index: 1;
        }

        .star {
            position: absolute;
            background: white;
            width: 8px;
            height: 8px;
            clip-path: polygon(
                50% 0%,
                61% 35%,
                98% 35%,
                68% 57%,
                79% 91%,
                50% 70%,
                21% 91%,
                32% 57%,
                2% 35%,
                39% 35%
            );
            opacity: 0;
            animation: twinkle 2s infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        .btn-primary {
            background: #6c26bb;
            border: none; 
        }
        .btn-primary:hover {
            background: #9d48ec;
        }

        .btn-social {
            background: #3b3e6d;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            transition: background 0.3s;
            flex: 1; /* Isso garante que os botões ocupem espaço igual */
        }

        .btn-social:hover {
            background: #7016d6;
        }

        .social-buttons {
            display: flex;
            justify-content: space-between; /* Usa espaço entre os botões */
            margin-bottom: 1rem; /* Adiciona um pouco de espaço abaixo dos botões */
        }

        .text-link {
            color: white;
            transition: color 0.3s;
        }

        .text-link:hover {
            color: #9d48ec;
        }
    </style>
</head>
<body>

<div class="title">Artist Supply</div>

<div class="login-container">
    <h2 class="text-center">Login</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </div>
        
        <div class="social-buttons">
            <button type="button" class="btn btn-social"><i class="fab fa-google"></i> Google</button>
            <button type="button" class="btn btn-social"><i class="fab fa-facebook-f"></i> Facebook</button>
        </div>

        <div class="text-center">
            <a href="{{ route('password.request') }}" class="text-link">Esqueceu sua senha?</a><br>
            <a href="{{ route('register') }}" class="text-link">Não possui uma conta? Criar uma conta</a>
        </div>
    </form>
</div>

<!-- Estrelas de fundo -->
<div class="star" style="top: 5%; left: 10%; animation-delay: 0s;"></div>
<div class="star" style="top: 10%; left: 80%; animation-delay: 0.5s;"></div>
<div class="star" style="top: 15%; left: 30%; animation-delay: 1s;"></div>
<div class="star" style="top: 25%; left: 20%; animation-delay: 1.2s;"></div>
<div class="star" style="top: 35%; left: 70%; animation-delay: 0.8s;"></div>
<div class="star" style="top: 45%; left: 15%; animation-delay: 1.4s;"></div>
<div class="star" style="top: 55%; left: 65%; animation-delay: 0.6s;"></div>
<div class="star" style="top: 65%; left: 5%; animation-delay: 0.9s;"></div>
<div class="star" style="top: 75%; left: 90%; animation-delay: 1.1s;"></div>
<div class="star" style="top: 85%; left: 50%; animation-delay: 1.3s;"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: '{{ session('error') }}',
                background: '#121120',
                color: 'white',
                confirmButtonColor: '#6c26bb',
                position: 'top', // Posiciona o alert no topo
                toast: true, // Faz o alert aparecer como um toast
                showConfirmButton: false,
                timer: 3000, // Dura 3 segundos
            });
        @endif
    });
</script>
</body>
</html>
