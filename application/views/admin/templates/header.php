<nav class="navbar navbar-default navbar-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#open-collapse"> 
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button> 
    </div>
    <div class="collapse navbar-collapse" id="open-collapse">
        <div class="container">
            <div class="row">
                <div class="col-md-6 logo-text">
                    <img class="logo" src="<?php echo base_url() ?>/assets/images/logo.png" />Apurbo Group
                </div>
            </div>
        </div>
    </div>
</nav>

<script type="text/javascript">
    /*$(function(){
        $("#search_box").typeahead([
            {
                name:"search_supplier",
                prefetch:{
                            url: '<?php echo base_url()?>search/get_supplier',
                            ttl: 0
                        },
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Supplier</div>',
                template: [
                    '<div class="col-md-9">'+
                        '<div class="row col-md-12 profile-name">'+
                            '{{first_name}} {{last_name}}'+
                        '</div>'+  
                        '<div class="row col-md-12">'+
                            '{{phone}} {{company}}'+
                        '</div>'+
                    '</div>'
                  ].join(''),
                engine: Hogan
            }
    ]);
        
    });*/
</script>