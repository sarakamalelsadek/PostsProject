<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your post approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            background:rgb(247, 247, 246);
            color:rgb(28, 25, 25);
            padding: 15px;
            font-size: 24px;
            border-radius: 8px 8px 8px 8px;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333;
            text-align: left;
        }
       
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        congratulation {{ $post->user->name }}!
    </div>

    <div class="content">
        <p>Congratulations. 🎉</p>
        <p>your post been approved you can show it now!</p>
    </div>

    <div class="footer">
        <p>If you have any questions, contact us!</p>
        <p>&copy; {{ date('Y') }} Our Platform. All rights reserved.</p>
    </div>
</div>

</body>
</html>
