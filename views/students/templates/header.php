<!DOCTYPE html>
<html>

<head>
    <script src="https://kit.fontawesome.com/a4ee4df788.js" crossorigin="anonymous"></script>
    <link href="/public/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a4ee4df788.js" crossorigin="anonymous"></script>
    <style>
        .card-shadow {
            box-shadow: 4px 2px 35px -16px rgba(0, 0, 0, 0.75);
            -webkit-box-shadow: 4px 2px 35px -16px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 4px 2px 35px -16px rgba(0, 0, 0, 0.75);
        }

        .card {
            -webkit-box-shadow: 10px 10px 15px -13px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 10px 10px 15px -13px rgba(0, 0, 0, 0.75);
            box-shadow: 10px 10px 15px -13px rgba(0, 0, 0, 0.75);
        }

        .right-side-container {
            background-color: #eaeaea;
            height: 100vh;
            overflow: scroll;
        }

        .nav-link {
            color: white;
        }

        .table-avatar {
            width: 60px;
            border-radius: 10px;
        }

        .chat-bubble {
            display: inline-block;
            max-width: 75%;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .chat-bubble-sender {
            background-color: #DCF8C6;
            float: right;
            margin: 1em 3em;
        }

        .chat-bubble-recipient {
            background-color: #C7DEF2;;
            float: left;
            margin: 1em 3em;
        }
    </style>
</head>

<body>