<html>

<head>
    <title>cgrd</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="main.js"></script>

</head>

<body>
    <div class="wrapper">
        <div class="logo-wrapper">
            <img src="images/logo.svg" alt="Title Image">
        </div>
        <div id="message" class="alert"></div>


        <form id="login-form">
            <input type="text" id="username" placeholder="Username" required>
            <input type="password" id="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>


        <div id="app" style="display: none;">
            <section id="news" style="display:none;">
            </section>
            <form id="news-form">
                <section class="form-header">
                    <h3>Create News</h3>
                    <a href="#" id="reset-form" style="display:none"><img src="images/close.svg" style="height:15px;"
                            alt="Delete"></a>
                </section>
                <input type="hidden" id="news-id" value="">
                <input type="text" id="news-title" placeholder="Title" required>
                <textarea id="news-description" required placeholder="Description"></textarea>
                <button type="submit">Create</button>
                <button id="logout-btn">Logout</button>
            </form>
        </div>
    </div>

</body>

</html>