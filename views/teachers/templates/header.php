<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>


    <style>
        .card-shadow {
            box-shadow: 4px 2px 35px -16px rgba(0, 0, 0, 0.75);
            -webkit-box-shadow: 4px 2px 35px -16px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 4px 2px 35px -16px rgba(0, 0, 0, 0.75);
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

        #map {
            height: 700px;
            width: 100%;
        }


        h1,
        h2,
        h3 {
            font-weight: bold;
        }

        .h1 {
            font-size: 2.5rem;
        }

        #calendar {
            width: 100%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            width: 100px;
            height: 100px;
            border: 1px solid #ccc;
        }

        td:hover {
            background-color: #f2f2f2;
            cursor: pointer;
        }

        .prev-month,
        .next-month {
            cursor: pointer;
            font-weight: bold;
        }

        .has {
            background-color: red;
        }

        .today {
            background-color: #8686ff;
            color: white;
        }

        .today:hover {
            background-color: #6b6bee;
            color: white;
        }

        .disable {
            background-color: rgb(198, 198, 198);

        }

        .disable:hover {
            background-color: rgb(198, 198, 198);
            cursor: not-allowed;

        }

        img.leaflet-marker-icon {
            border-radius: 10px;

        }

        .calendar-car-item {
            font-size: 10px;
            padding: 2px;
            border-radius: 10px;
            background: black;
            margin: 3px auto;
            font-weight: bold;
        }

        .calendar-car-item a{
            color: white;
        }
    </style>
</head>
<body>