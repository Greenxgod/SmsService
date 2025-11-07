<?php
$this->title = 'SMS Верификация';
?>
<!DOCTYPE html>
<html>
<head>
    <title>SMS Верификация</title>
    <meta charset="utf-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .verification-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            position: relative;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }
        
        .test-code-banner {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .test-code {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 3px;
            margin: 10px 0;
            background: rgba(255,255,255,0.2);
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        .input-group {
            position: relative;
        }
        
        .phone-prefix {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-weight: 500;
        }
        
        input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        input:disabled {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        
        .code-input {
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 8px;
            padding-left: 15px;
        }
        
        .code-input::placeholder {
            letter-spacing: normal;
            color: #999;
        }
        
        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }
        
        button {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-send {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-send:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-verify {
            background: #28a745;
            color: white;
        }
        
        .btn-verify:hover:not(:disabled) {
            background: #218838;
            transform: translateY(-2px);
        }
        
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }
        
        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-weight: 500;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .timer {
            text-align: center;
            margin-top: 10px;
            color: #666;
            font-size: 14px;
        }
        
        .input-hint {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }
        
        .demo-notice {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            border: 1px solid #ffeaa7;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="logo">
            <h1>SMS Верификация</h1>
        </div>
        
        <!-- Тестовый баннер с кодом -->
        <div id="testCodeBanner" class="test-code-banner" style="display: none;">
            <div><strong>ТЕСТОВЫЙ РЕЖИМ</strong></div>
            <div>Код из SMS:</div>
            <div id="testCodeValue" class="test-code"></div>
            <div style="font-size: 12px; opacity: 0.9;">Используйте этот код для подтверждения</div>
        </div>
        
        <div class="form-group">
            <label for="phone">Номер телефона</label>
            <div class="input-group">
                <span class="phone-prefix">+7</span>
                <input 
                    id="phone"
                    type="tel"
                    placeholder="999 123-45-67"
                    maxlength="15"
                >
            </div>
            <div class="input-hint">Введите 10 цифр номера без +7</div>
        </div>

        <div class="form-group">
            <label for="code">Код подтверждения</label>
            <input 
                id="code"
                type="text"
                placeholder="____"
                maxlength="4"
                class="code-input"
                disabled
            >
        </div>

        <div class="buttons">
            <button id="sendBtn" class="btn-send" onclick="sendCode()">
                Отправить код
            </button>
            <button id="verifyBtn" class="btn-verify" onclick="verifyCode()" disabled>
                Подтвердить
            </button>
        </div>

        <div id="timer" class="timer" style="display: none;"></div>
        
        <div id="message"></div>
        
        <div class="demo-notice">
            Демо-режим: код из SMS показывается на экране
        </div>
    </div>

    <script>
        const phoneInput = document.getElementById('phone');
        const codeInput = document.getElementById('code');
        const sendBtn = document.getElementById('sendBtn');
        const verifyBtn = document.getElementById('verifyBtn');
        const timerDiv = document.getElementById('timer');
        const messageDiv = document.getElementById('message');
        const testCodeBanner = document.getElementById('testCodeBanner');
        const testCodeValue = document.getElementById('testCodeValue');

        let cooldown = 0;
        let cooldownInterval;
        let lastGeneratedCode = '';

        // Маска для телефона
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.replace(/(\d{3})(\d{0,3})/, '$1 $2');
                } else if (value.length <= 8) {
                    value = value.replace(/(\d{3})(\d{3})(\d{0,2})/, '$1 $2-$3');
                } else {
                    value = value.replace(/(\d{3})(\d{3})(\d{2})(\d{0,2})/, '$1 $2-$3-$4');
                }
            }
            
            e.target.value = value;
            updateSendButton();
        });

        // Маска для кода (только цифры)
        codeInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
            updateVerifyButton();
        });

        function updateSendButton() {
            const phoneDigits = phoneInput.value.replace(/\D/g, '');
            sendBtn.disabled = phoneDigits.length !== 10 || cooldown > 0;
        }

        function updateVerifyButton() {
            verifyBtn.disabled = codeInput.value.length !== 4;
        }

        function startCooldown() {
            cooldown = 60;
            timerDiv.style.display = 'block';
            updateSendButton();
            
            cooldownInterval = setInterval(() => {
                cooldown--;
                timerDiv.textContent = `Повторная отправка через ${cooldown} сек`;
                
                if (cooldown <= 0) {
                    clearInterval(cooldownInterval);
                    timerDiv.style.display = 'none';
                    updateSendButton();
                }
            }, 1000);
        }

        function showTestCode(code) {
            lastGeneratedCode = code;
            testCodeValue.textContent = code;
            testCodeBanner.style.display = 'block';
            
            // Автоскрытие через 2 минуты
            setTimeout(() => {
                testCodeBanner.style.display = 'none';
            }, 120000);
        }

        async function sendCode() {
            const phoneDigits = phoneInput.value.replace(/\D/g, '');
            const fullPhone = '+7' + phoneDigits;
            
            showMessage('Отправка кода...', 'info');
            sendBtn.disabled = true;
            sendBtn.textContent = 'Отправка...';

            try {
                const response = await fetch('/api/sms/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        phone: fullPhone
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    showMessage(`Код отправлен на номер ${fullPhone}`, 'success');
                    codeInput.disabled = false;
                    codeInput.focus();
                    startCooldown();
                    
                    // Показываем тестовый код
                    if (result.data.code) {
                        showTestCode(result.data.code);
                    }
                } else {
                    showMessage(result.error, 'error');
                }
            } catch (error) {
                showMessage('Ошибка сети', 'error');
            } finally {
                sendBtn.textContent = 'Отправить код';
                updateSendButton();
            }
        }

        async function verifyCode() {
            const phoneDigits = phoneInput.value.replace(/\D/g, '');
            const fullPhone = '+7' + phoneDigits;
            const code = codeInput.value;
            
            showMessage('Проверка кода...', 'info');
            verifyBtn.disabled = true;
            verifyBtn.textContent = 'Проверка...';

            try {
                const response = await fetch('/api/sms/verify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        phone: fullPhone,
                        code: code
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    showMessage('Номер успешно подтвержден!', 'success');
                    testCodeBanner.style.display = 'none';
                    
                    // Дополнительные действия после успешной верификации
                    setTimeout(() => {
                        showMessage('Добро пожаловать! Верификация завершена.', 'success');
                    }, 1000);
                } else {
                    showMessage(result.error, 'error');
                    codeInput.value = '';
                    codeInput.focus();
                }
            } catch (error) {
                showMessage('Ошибка сети', 'error');
            } finally {
                verifyBtn.textContent = 'Подтвердить';
                updateVerifyButton();
            }
        }

        function showMessage(text, type) {
            messageDiv.textContent = text;
            messageDiv.className = 'message ' + type;
            messageDiv.style.display = 'block';
            
            // Автоскрытие успешных сообщений
            if (type === 'success') {
                setTimeout(() => {
                    messageDiv.style.display = 'none';
                }, 5000);
            }
        }

        // Enter для отправки/подтверждения
        phoneInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !sendBtn.disabled) {
                sendCode();
            }
        });

        codeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !verifyBtn.disabled) {
                verifyCode();
            }
        });

        // Автозаполнение кода по клику на тестовый баннер
        testCodeBanner.addEventListener('click', function() {
            if (lastGeneratedCode) {
                codeInput.value = lastGeneratedCode;
                updateVerifyButton();
                codeInput.focus();
            }
        });
    </script>
</body>
</html>
