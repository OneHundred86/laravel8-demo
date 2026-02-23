<!-- resources/views/sse-test.blade.php -->
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSE 测试页面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        #log {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 15px;
            height: 400px;
            overflow-y: auto;
            font-family: monospace;
        }

        .event-connected {
            color: green;
        }

        .event-message {
            color: blue;
        }

        .event-heartbeat {
            color: orange;
        }

        .event-error {
            color: red;
        }

        button {
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Laravel SSE 实时推送测试</h1>

    <div>
        <button onclick="connectBasic()">连接基础流 (10条消息)</button>
        <button onclick="connectHeartbeat()">连接心跳流 (长连接)</button>
        <button onclick="disconnect()">断开连接</button>
        <button onclick="clearLog()">清空日志</button>
    </div>

    <h3>事件日志：</h3>
    <div id="log"></div>

    <script>
        let eventSource = null;
        const logDiv = document.getElementById('log');

        function log(message, className = '') {
            const entry = document.createElement('div');
            entry.className = className;
            entry.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
            logDiv.appendChild(entry);
            logDiv.scrollTop = logDiv.scrollHeight;
        }

        function connectBasic() {
            disconnect();
            log('正在连接基础 SSE 流...', 'event-connected');

            eventSource = new EventSource('/sse/stream');

            eventSource.onopen = () => log('连接已打开', 'event-connected');

            eventSource.addEventListener('connected', (e) => {
                log(`连接事件: ${e.data}`, 'event-connected');
            });

            eventSource.addEventListener('message', (e) => {
                const data = JSON.parse(e.data);
                log(`消息 #${data.id}: ${data.message} (内存: ${data.memory})`, 'event-message');
            });

            eventSource.addEventListener('close', (e) => {
                log(`关闭事件: ${e.data}`, 'event-connected');
                disconnect();
            });

            eventSource.onerror = (e) => {
                log('连接错误', 'event-error');
                console.error(e);
            };
        }

        function connectHeartbeat() {
            disconnect();
            log('正在连接心跳 SSE 流...', 'event-connected');

            eventSource = new EventSource('/sse/heartbeat');

            eventSource.addEventListener('connected', (e) => {
                const data = JSON.parse(e.data);
                log(`连接成功: IP=${data.client_ip}`, 'event-connected');
            });

            eventSource.addEventListener('heartbeat', (e) => {
                log(`心跳: ${JSON.parse(e.data).time}`, 'event-heartbeat');
            });

            eventSource.addEventListener('notification', (e) => {
                const data = JSON.parse(e.data);
                log(`通知: ${data.title} - ${data.content}`, 'event-message');
            });

            eventSource.onerror = (e) => {
                log('连接错误', 'event-error');
            };
        }

        function disconnect() {
            if (eventSource) {
                eventSource.close();
                eventSource = null;
                log('连接已手动关闭', 'event-connected');
            }
        }

        function clearLog() {
            logDiv.innerHTML = '';
        }

        // 页面关闭时断开连接
        window.onbeforeunload = disconnect;
    </script>
</body>

</html>