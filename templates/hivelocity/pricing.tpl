<link href="{assetPath file='customrange.css'}" rel="stylesheet">
<h2 class="text-center">Track down Your Ideal Server</h2>
<p class="text-center">Upheld by all day, every day On-Premises Backing</p>
<br>
<div class="row">
	<div class="col-md-2">
		<p><strong>Sort by</strong></p>
		<select id="sortbyprice" class="form-control">
	          <option value="ASC">Price low to high</option>
	          <option value="DESC">Price high to low</option>
		</select>
		<br>
		<div id="grouptype">
			<p><strong>Category</strong></p>
			{foreach from=$productgroups key=k item=v}
			     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="group" class="form-check-input" value="{$v['id']}" {if $v["id"] eq $smarty.get.gid}checked{/if}>
				{$v['name']}<br>
			{/foreach}
		</div>
		<form class="multi-range-field my-5 pb-5">
			<p><strong>Pricing ($<span class="rangefrom">1</span> - $<span class="rangeto">1000</span>)</strong></p>
			<input id="multirange" class="multi-range" type="range" />
			<input type="hidden" id="rangefrom" value="1" class="form-control">
			<input type="hidden" id="rangeto" value="1000" class="form-control">
		</form>
		<div id="sortbyloc">
			<p><strong>Location</strong></p>
			{foreach from=$grouplocations key=k item=v}
	          	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="loc" class="form-check-input" value="{$k}">
				{$v}<br>
	          {/foreach}
		</div>
	</div>
	<div id="pricingproduct" class="col-md-10">
		{$htmlcontent}
	</div>
</div>

<script src="{assetPath file='customrange.js'}"></script>
<script>
	$('#multirange').mdbRange({
	  single: {
	    active: true,
	    multi: {
	      active: true,
	      rangeLength: 2,
	      counting: true,
	      countingTarget: ['#rangefrom', '#rangeto']
	    },
	  },
	  value: {
            min: 1,
            max: 1000,
  	  }
	},
	$(this).on('change', (e) => {
          
          var from=$('#rangefrom').val();
          var to=$('#rangeto').val();

	    if(from)
	    	$('.rangefrom').text(from);
	    
	    if(to)
	    	$('.rangeto').text(to);

	     postAjax();
        })
	);

	$('#sortbyprice').on('change', function () {
		
		var value = $(this).val();
          $(this).find('option[value="' + value + '"]').attr("selected", "selected");

	     postAjax();
	});

	$('#sortbyloc input[type=checkbox]').click(function () {
		postAjax();
	});

	$('#grouptype input[type=checkbox]').click(function () {
		postAjax();
	});

	function postAjax()
	{
		var productgroups = [];
          $('#grouptype input[type=checkbox]:checked').each(function () {   
			productgroups.push($(this).val());
          });

          var productloc = [];
          $('#sortbyloc input[type=checkbox]:checked').each(function () {   
			productloc.push($(this).val());
          });

		var from=$('#rangefrom').val();
          var to=$('#rangeto').val();

          var data = {
			sortorder: $('#sortbyprice').find(":selected").val(),
			rangefrom: from,
			rangeto: to,
			groupids: productgroups,
			location: productloc
	     };

		$.ajax({
	      url: '/pricing.php',
	      method: "POST",
	      data: data
	    }).done(function (response) {
	      $('#pricingproduct').html(response);
	    }).fail(function (err) {
	      console.log(err);
	    })
	}	
</script>