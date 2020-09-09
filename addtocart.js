function updatecart(sauceid)
	{
		var quantity= $('#quantity').val();
		var pizzaid= $('#pizzaid').text();
		console.log(pizzaid);
		 $.ajax({
        url:'addtocart.php',
        type:'post',
        dataType:'text',
        data:{'pizzaid':pizzaid, 'quantity':quantity,'sauceid':sauceid },
        success:function(data){
            $("#count").text(data);
            window.location="cartviewer.php";
        }

    });
	}