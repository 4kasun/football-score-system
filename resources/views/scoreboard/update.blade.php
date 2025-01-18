<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Scoreboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .team-input {
            width: 50%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .team-score {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .team-score button {
            padding: 10px 15px;
            font-size: 16px;
            margin: 0 5px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .team-score button:hover {
            background-color: #0056b3;
        }

        .team-score span {
            font-size: 20px;
            font-weight: bold;
        }

        .status {
            margin-top: 20px;
        }

        .status label {
            margin-right: 10px;
        }

        button.submit {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button.submit:hover {
            background-color: #218838;
        }

        .logout {
            text-align: right;
            margin-bottom: 20px;
        }

        .logout a {
            color: red;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logout">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <h1>Update Scoreboard</h1>

        @if(session('success'))
        <div class="success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('scoreboard.update') }}">
            @csrf
            <label for="teams">Teams</label>
            <input type="text" id="teams" name="teams"
                value="{{ old('teams', $scoreboard['teams'] ?? 'Team A vs Team B') }}"
                placeholder="Team A vs Team B" required class="team-input">

            <div class="team-score">
                <label>Team A:</label>
                <button type="button" onclick="updateScore('teamA', -1)">-</button>
                <span id="teamA-score">{{ old('teamA', $scoreboard['score']['teamA'] ?? 0) }}</span>
                <button type="button" onclick="updateScore('teamA', 1)">+</button>
                <input type="hidden" name="teamA" id="teamA-input" value="{{ old('teamA', $scoreboard['score']['teamA'] ?? 0) }}">
            </div>

            <div class="team-score">
                <label>Team B:</label>
                <button type="button" onclick="updateScore('teamB', -1)">-</button>
                <span id="teamB-score">{{ old('teamB', $scoreboard['score']['teamB'] ?? 0) }}</span>
                <button type="button" onclick="updateScore('teamB', 1)">+</button>
                <input type="hidden" name="teamB" id="teamB-input" value="{{ old('teamB', $scoreboard['score']['teamB'] ?? 0) }}">
            </div>

            <div class="status">
                <label>Match Status:</label>
                <label>
                    <input type="radio" name="status" value="Not Started"
                        {{ old('status', $scoreboard['status'] ?? '') === 'Not Started' ? 'checked' : '' }} required>
                    Not Started
                </label>
                <label>
                    <input type="radio" name="status" value="In Progress"
                        {{ old('status', $scoreboard['status'] ?? '') === 'In Progress' ? 'checked' : '' }}>
                    In Progress
                </label>
                <label>
                    <input type="radio" name="status" value="Completed"
                        {{ old('status', $scoreboard['status'] ?? '') === 'Completed' ? 'checked' : '' }}>
                    Completed
                </label>
            </div>

            <button type="submit" class="submit">Update Scoreboard</button>
        </form>
    </div>

    <script>
        function updateScore(team, increment) {
            const scoreElement = document.getElementById(`${team}-score`);
            const inputElement = document.getElementById(`${team}-input`);
            let currentScore = parseInt(scoreElement.textContent);

            // Update score
            currentScore += increment;

            // Prevent negative scores
            if (currentScore < 0) currentScore = 0;

            // Update UI and hidden input
            scoreElement.textContent = currentScore;
            inputElement.value = currentScore;
        }
    </script>
</body>

</html>