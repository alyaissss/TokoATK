<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up ATK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { height: 100vh; display: flex; justify-content: center; align-items: center; background-color: #f3e7d8; padding: 1.5rem; }

        .box { width: 100%; max-width: 380px; padding: 2.5rem 2rem; background: #fcf5eb; border-radius: 12px; border: 1px solid #d3bca4; box-shadow: 0 4px 6px -1px rgba(92,64,51,0.12); color: #403127; }
        h2 { text-align: center; font-size: 1.35rem; font-weight: 700; color: #5b3f2f; margin-bottom: 1.5rem; }

        label { display: block; font-size: 0.875rem; font-weight: 500; color: #7b6654; margin-bottom: 0.4rem; margin-top: 1rem; }
        input { width: 100%; padding: 0.625rem 0.75rem; font-size: 0.9rem; border-radius: 6px; border: 1px solid #d3bca4; outline: none; transition: border-color 0.2s; margin-bottom: 0.25rem; }
        input:focus { border-color: #a88665; box-shadow: 0 0 0 3px rgba(168,134,101,0.15); }

        button { width: 100%; padding: 0.75rem; background: #6c4d37; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.9rem; margin-top: 1.5rem; transition: background 0.2s; }
        button:hover { background: #5a3f31; }

        p { font-size: 0.875rem; color: #7b6654; margin-top: 1.25rem; text-align: center; }
        a { color: #6c4d37; text-decoration: none; font-weight: 600; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="box">
    <h2>Sign Up ATK</h2>

    <form action="proses_signup.php" method="POST">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" required placeholder="Nama Anda">

        <label>Email Resmi</label>
        <input type="email" name="email" required placeholder="nama@email.com">

        <label>Password</label>
        <input type="password" name="password" required placeholder="••••••••">

        <button type="submit" name="daftar">Daftar</button>
    </form>

    <p>
        Sudah punya akun? <a href="signin.php">Masuk</a>
    </p>
</div>
</body>
</html>