<?php $this->layout('layout') ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>All Tasks</h1>
            <table class="table">
                <thead>
                <tr>
                    <th>UID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($tables as $table):?>
                <tr>
                    <td><?= $table['id'];?></td>
                    <td><?= $table['name'];?></td>
                    <td><?= $table['age'];?></td>
                    <td><?= $table['email'];?></td>
                    <td><?= $table['phone'];?></td>
                    <td><?= $table['gender'];?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="/" class="btn btn-primary">
        General page
    </a>
</div>

