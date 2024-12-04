<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Operations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 0 auto;
            width: 50%;
            padding: 20px;
            text-align: center;
        }
        textarea {
            width: 100%;
            height: 150px;
            margin-top: 10px;
        }
        .matrix {
            margin: 20px 0;
        }
        input[type="number"] {
            width: 50px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Matrix Operations</h1>
    <form action="test.php" method="post">
        <label for="rows">Rows (m): </label>
        <input type="number" id="rows" name="rows" min="2" max="5" required>
        <label for="columns">Columns (n): </label>
        <input type="number" id="columns" name="columns" min="2" max="5" required>
        <br><br>
        <button type="submit">Generate Matrix</button>
    </form>

    <?php if (isset($_POST['rows']) && isset($_POST['columns'])): ?>
        <div class="matrix">
            <h2>Generated Matrix</h2>
            <textarea readonly>
                    <?php include 'matrix.php'; ?>
                </textarea>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
