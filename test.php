<!DOCTYPE html>
<html>
<head>
    <title>JavaScript Selected Value</title>
    <link href="css/selectbox.css" rel="stylesheet">
</head>
<body>
    <div id="container">


    <?php  
   
   $number = '100';
$percentage = '.08';
$product = $number - ($number * $percentage);
echo $product;
    
    ?>
        <form action="create-payroll.php" method="post">
            <label for="name">Framework:</label>
            <input list="employee" type="text" id="name" placeholder="Enter a framework" autocomplete="off">


            <datalist  id="employee" >
      
            <option >Cedric Drilon Isubol </option>
            <option>Arries Dave Bantigue</option>
            <option>Christian Santiago</option>
            <option>James Benny Nemenzo</option>
            </datalist>  
  

            <button id="btnAdd">Add</button>

            <div id="dl">
            </div>

            <label for="list">Framework List:</label>
            <select id="list" name="employee[]" multiple style="height:300px">
          
            </select>
            <button id="btnRemove">Remove Selected Framework</button>
            <input type="submit" name="sample" >
        </form>
    </div>

    <script>
        const btnAdd = document.querySelector('#btnAdd');
        const btnRemove = document.querySelector('#btnRemove');
        const sb = document.querySelector('#list');
        const dl = document.querySelector('#dl');
        const name = document.querySelector('#name');
        const name2 = document.querySelector('#dl');

        btnAdd.onclick = (e) => {
            e.preventDefault();

            // validate the option
            // if (name.value == '') {
            //     alert('Please enter the name.');
            //     return;
            // }
            // create a new option
            const option = new Option(name.value, name.value);

            const datalist = new DataList();
            // add it to the list
            sb.add(option, undefined);

            dl.add(datalist, undefined);


            //select or highlight all options in select
    	options = document.getElementsByTagName("option");
    	for ( i=0; i<options.length; i++)
    	{
    		options[i].selected = "true";
    	}
    

            // reset the value of the input
            name.value = '';
            name.focus();
        };

        // remove selected option
        btnRemove.onclick = (e) => {
            e.preventDefault();

            // save the selected option
            let selected = [];

            for (let i = 0; i < sb.options.length; i++) {
                selected[i] = sb.options[i].selected;
            }

            // remove all selected option
            let index = sb.options.length;
            while (index--) {
                if (selected[index]) {
                    sb.remove(index);
                }
            }
        };
    </script>
</body>
</html>