<?php
$mysqli = new mysqli("db", "root", "example", "todo_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = $_POST["task"];
    $stmt = $mysqli->prepare("INSERT INTO todos (task) VALUES (?)");
    $stmt->bind_param("s", $task);
    $stmt->execute();
}

$result = $mysqli->query("SELECT task FROM todos");
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>ToDo-Liste</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            font-size: 1em;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #218838;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
        }

        li {
            background: #f0f2f5;
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Meine ToDo-Liste</h1>
        <form method="post">
            <input type="text" name="task" placeholder="Neue Aufgabe..." required>
            <button type="submit">Hinzufügen</button>
        </form>

        <ul>
        <?php while ($row = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row["task"]) . "</li>";
        } ?>
        </ul>
    </div>
</body>
</html>
