<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo isset($title) ? $title : 'Bistro Elegance'; ?></title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            padding-top: 50px;
        }

        form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            font-size: 0.9em;
        }
    </style>

</head>

<body>
    <div class="login-wrapper">
        <?= $content ?>
    </div>
</body>
</html>