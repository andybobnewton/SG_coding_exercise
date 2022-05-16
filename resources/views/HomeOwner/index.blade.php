<html>
    <body>
        <h1>Home owner upload</h1>
        
        <?php 
        if (isset($flash_message)){
            echo "<h3>{$flash_message}</h3>";
        }

        ?>
        <form action="/HomeOwner/uploadCSV" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button>Submit</button>
        </form>

        <table>
            <tr>
                <th>Title</th>
                <th>First Name</th>
                <th>Initial</th>
                <th>Last Name</th>
            </tr>
            <?php 
                foreach ($latest_imports as $home_owner) {
             ?>
               <tr> 
                   <td>
                       {{ $home_owner->title}}
                   </td>
                   <td>
                       {{ $home_owner->first_name}}
                   </td>
                   <td>
                       {{ $home_owner->initial}}
                   </td>
                   <td>
                       {{ $home_owner->last_name}}
                   </td>
               </tr>   
            <?php   
                }
             ?>
        </table>

    </body>
</html>