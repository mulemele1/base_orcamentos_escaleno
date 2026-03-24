<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carregando - Escaleno Gestão de Obra</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
            position: relative;
        }

        /* Overlay de gradiente */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Container Principal - Design Retangular */
        .progress-container {
            background: #ffffff;
            border-radius: 0;
            padding: 48px 56px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.05);
            max-width: 520px;
            width: 90%;
            text-align: center;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo */
        .logo {
            margin-bottom: 32px;
        }

        .logo-icon {
            font-size: 48px;
            color: #4f46e5;
            margin-bottom: 12px;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.3px;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 13px;
            font-weight: 400;
            color: #6b7280;
        }

        /* Barra de Progresso */
        .progress-section {
            margin: 32px 0 24px;
        }

        .progress-bar {
            height: 4px;
            background: #e5e7eb;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #4f46e5;
            width: 0%;
            transition: width 0.05s linear;
        }

        .progress-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            font-size: 13px;
            font-weight: 500;
        }

        .percentage {
            color: #4f46e5;
        }

        .time {
            color: #6b7280;
        }

        /* Mensagem Principal */
        .message {
            margin: 24px 0 28px;
            padding: 0 8px;
        }

        .main-message {
            font-size: 15px;
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 6px;
        }

        .secondary-message {
            font-size: 13px;
            font-weight: 400;
            color: #9ca3af;
        }

        /* Card de Status Simplificado */
        .status-card {
            background: #f9fafb;
            padding: 16px 20px;
            margin: 24px 0;
            text-align: left;
            border: 1px solid #f3f4f6;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .status-icon {
            width: 32px;
            height: 32px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
        }

        .status-icon i {
            font-size: 14px;
            color: #4f46e5;
        }

        .status-text {
            flex: 1;
        }

        .status-label {
            font-size: 11px;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .status-value {
            font-size: 13px;
            font-weight: 500;
            color: #111827;
        }

        /* Footer */
        .footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
        }

        .developer {
            font-size: 11px;
            font-weight: 400;
            color: #9ca3af;
        }

        .developer i {
            margin-right: 6px;
            color: #4f46e5;
            font-size: 10px;
        }

        /* Botão Skip */
        .skip-btn {
            margin-top: 12px;
            background: none;
            border: none;
            font-size: 11px;
            font-weight: 500;
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.2s ease;
            font-family: 'Roboto', sans-serif;
        }

        .skip-btn:hover {
            color: #4f46e5;
        }

        /* Loading Dots */
        .dots::after {
            content: '...';
            animation: dots 1.2s steps(3, end) infinite;
        }

        @keyframes dots {
            0%, 20% { content: '.'; }
            40% { content: '..'; }
            60%, 100% { content: '...'; }
        }

        /* Responsividade */
        @media (max-width: 480px) {
            .progress-container {
                padding: 32px 24px;
            }
            
            .logo-icon {
                font-size: 40px;
            }
            
            h1 {
                font-size: 20px;
            }
            
            .status-card {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="progress-container">
        <!-- Logo -->
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h1>Escaleno</h1>
            <div class="subtitle">Gestão de Obra</div>
        </div>

        <!-- Progresso -->
        <div class="progress-section">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="progress-stats">
                <span class="percentage" id="percentage">0%</span>
                <span class="time" id="timeText">5 segundos</span>
            </div>
        </div>

        <!-- Mensagem -->
        <div class="message">
            <div class="main-message" id="mainMessage">
                <i class="fas fa-spinner fa-spin" style="margin-right: 6px;"></i>
                Carregando sistema<span class="dots"></span>
            </div>
            <div class="secondary-message" id="secondaryMessage">
                Preparando seu ambiente
            </div>
        </div>

        <!-- Status Card (Simplificado) -->
        <div class="status-card">
            <div class="status-item">
                <div class="status-icon">
                    <i class="fas fa-chart-simple" id="statusIcon"></i>
                </div>
                <div class="status-text">
                    <div class="status-label">Status</div>
                    <div class="status-value" id="statusText">Inicializando</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="developer">
                <i class="fas fa-code"></i> Desenvolvido por Jacinto da Costa
            </div>
            <button class="skip-btn" id="skipBtn">
                <i class="fas fa-forward"></i> Acessar agora
            </button>
        </div>
    </div>

    <script>
        // Configuração: 5 segundos
        const TOTAL_TIME = 5;
        let currentSecond = 0;
        
        // Elementos
        const progressFill = document.getElementById('progressFill');
        const percentageSpan = document.getElementById('percentage');
        const timeText = document.getElementById('timeText');
        const mainMessageSpan = document.getElementById('mainMessage');
        const secondaryMessageSpan = document.getElementById('secondaryMessage');
        const statusText = document.getElementById('statusText');
        const statusIcon = document.getElementById('statusIcon');
        
        // Mensagens para cada segundo
        const messages = [
            { main: 'Inicializando módulos', secondary: 'Configurando ambiente', status: 'Inicializando' },
            { main: 'Carregando dados', secondary: 'Buscando informações', status: 'Carregando' },
            { main: 'Processando orçamentos', secondary: 'Preparando dashboard', status: 'Processando' },
            { main: 'Quase pronto', secondary: 'Últimos ajustes', status: 'Finalizando' },
            { main: 'Sistema pronto', secondary: 'Abrindo página inicial', status: 'Concluído' }
        ];
        
        // Ícones para cada status
        const icons = ['fa-chart-simple', 'fa-database', 'fa-cog', 'fa-check-circle', 'fa-check-circle'];
        
        // Redirecionar
        function redirectToHome() {
            const container = document.querySelector('.progress-container');
            container.style.transition = 'opacity 0.2s ease';
            container.style.opacity = '0';
            setTimeout(() => {
                window.location.href = "{{ route('recuperar') }}";
            }, 200);
        }
        
        // Atualizar interface
        function updateProgress() {
            if (currentSecond <= TOTAL_TIME) {
                const percent = (currentSecond / TOTAL_TIME) * 100;
                const remaining = TOTAL_TIME - currentSecond;
                
                // Barra e porcentagem
                progressFill.style.width = percent + '%';
                percentageSpan.textContent = Math.floor(percent) + '%';
                timeText.textContent = remaining + ' segundos';
                
                // Atualizar mensagens baseado no segundo atual
                const msgIndex = Math.min(currentSecond, messages.length - 1);
                if (currentSecond < TOTAL_TIME) {
                    mainMessageSpan.innerHTML = `<i class="fas fa-spinner fa-spin" style="margin-right: 6px;"></i> ${messages[msgIndex].main}<span class="dots"></span>`;
                    secondaryMessageSpan.textContent = messages[msgIndex].secondary;
                    statusText.textContent = messages[msgIndex].status;
                    statusIcon.className = `fas ${icons[msgIndex]}`;
                    
                    // Últimos segundos
                    if (remaining === 1) {
                        secondaryMessageSpan.textContent = 'Redirecionando agora...';
                    }
                }
                
                currentSecond++;
                setTimeout(updateProgress, 1000);
            } else {
                // Finalizado
                progressFill.style.width = '100%';
                percentageSpan.textContent = '100%';
                timeText.textContent = '0 segundos';
                mainMessageSpan.innerHTML = '<i class="fas fa-check-circle" style="margin-right: 6px; color: #10b981;"></i> Sistema carregado!';
                secondaryMessageSpan.textContent = 'Redirecionando...';
                statusText.textContent = 'Pronto';
                statusIcon.className = 'fas fa-check-circle';
                statusIcon.style.color = '#10b981';
                
                setTimeout(redirectToHome, 900);
            }
        }
        
        // Botão Skip
        document.getElementById('skipBtn').addEventListener('click', function() {
            redirectToHome();
        });
        
        // Iniciar
        setTimeout(updateProgress, 200);
    </script>
</body>
</html>