<?php
include 'config/dbcon.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placeholder for CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Client and Staff</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                </ul>
            </div>
        </div>
    </nav>

    <div class="container p-5">
        <div class="col">
            <div class="row p-1">
                <form action="api/employee/read.php">
                    <button class="btn btn-primary" type="submit">API</button>
                </form>
                <div class="row p-3">
                    <table class="table table-hover table-dark">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Login_Role</th>
                                <th></th>
                            </tr>
                            <tr>
                                <form action="config/employee/add.php" method="post">
                                    <th></th>
                                    <th><input class="form-control" placeholder="Enter username" type="text"
                                            name="username" required></th>
                                    <th><input class="form-control" placeholder="Enter password" type="text"
                                            name="password" required></th>
                                    <th>
                                        <select name="role" class="form-select">
                                            <option value="Admin">Admin</option>
                                            <option value="Employee">Employee</option>
                                        </select>
                                    </th>
                                    <th>
                                        <button class="btn btn-success" type="submit">Add</button>
                                    </th>
                                </form>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `tbl_employee_account`";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td></td>
                                    <td>
                                        <?= $row['username'] ?>
                                    </td>
                                    <td>********</td>
                                    <td>
                                        <?= $row['login_role'] ?>
                                    </td>
                                    <td>
                                        <form action="config/employee/delete.php" method="post">
                                            <input type="hidden" name="id" value="<?= $row['account_id'] ?>">
                                            <button type="submit" class="btn btn-danger form-control">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
</body>

</html>