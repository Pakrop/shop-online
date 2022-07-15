<?php require 'meta.php'; ?>
<div class="container mt-4">
    <form method="post">
        <input type="text" id="search" class="form-control">
    </form>
        <table class="table mt-5">
            <thead class="bg-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Email</th>
                <th scope="col">FirstName</th>
                <th scope="col">LastName</th>
            </tr>
            </thead>
            <tbody></tbody>            
        </table>
</div>
<?php require 'script.php'; ?>
<script>
    $(function(){
        $('#search').keyup(function(){
            var search = $('#search').val().trim();
            $.ajax({
                url: 'test.php',
                method: 'post',
                data: {
                    search: search
                },
                success: function(resp){
                    $('tbody').html(resp);
                    if(search == ""){
                        $('tbody').empty();
                    }  
                }
            });
        });
    });
</script>

