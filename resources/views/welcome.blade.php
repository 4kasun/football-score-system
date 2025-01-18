<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Live Football Score</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        .scoreboard {
            display: inline-block;
            padding: 20px;
            border: 2px solid #333;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .team {
            font-size: 1.5em;
            font-weight: bold;
        }

        .score {
            font-size: 2.5em;
            margin: 20px 0;
        }

        .status {
            font-size: 1.2em;
            color: #555;
        }
    </style>
</head>

<body>
    @vite('resources/js/app.js')
    <div class="scoreboard">
        <div class="team" id="teams">Team A vs Team B</div>
        <div class="score" id="score">0 - 0</div>
        <div class="status" id="status">Waiting for updates...</div>
    </div>
</body>
<script>
    setTimeout(() => {
        const teamsElement = document.getElementById('teams');
        const scoreElement = document.getElementById('score');
        const statusElement = document.getElementById('status');

        window.Echo.channel('football-match').listen('ScoreBoardEvent', (e) => {
            console.log(e);
            const data = e;
            console.log('Score update received:', data);
            if (data.teams) teamsElement.textContent = data.teams;
            if (data.score) scoreElement.textContent = data.score;
            if (data.status) statusElement.textContent = data.status;
        });

    }, 2000);
</script>

</html>