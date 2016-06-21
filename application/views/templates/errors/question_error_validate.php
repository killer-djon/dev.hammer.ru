<? if( !empty($errors) ): ?>
    <div class="container-fluid">

        <div class="row">
            <div class="col-xs-12 col-sm-12 wow fadeInRight animated">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="container-fluid">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h2><? echo $title;?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row" role="contentinfo">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="alert alert-info text-center">
                                    <? if(!empty($errors)): ?>
                                        <?foreach($errors as $key => $error):?>

                                        <?endforeach;?>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<? else: ?>
    <div class="container-fluid">

        <div class="row">
            <div class="col-xs-12 col-sm-12 wow fadeInRight animated">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="container-fluid">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h2><?=$title?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row" role="contentinfo">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <?=$timeout?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
<? endif; ?>
