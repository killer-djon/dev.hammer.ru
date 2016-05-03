<? if(!empty($page)): ?>
<?
Breadcrumbs::clean();
Breadcrumbs::set([
    URL::base() => 'Главная',
    '/'.$page['pagealias'] => $page['menutitle'],
]);
?>

<!-- Keep all page content within the page-content inset div! -->
<div class="container-fluid">

    <div class="row">
        <div class="col-xs-12 col-sm-12 wow fadeInRight animated">

            <div class="panel panel-default">
                
				<div class="panel-heading">
				    <div class="container-fluid">
				        <div class="col-xs-12 col-sm-12 col-md-12">
				            <h1><?=$page['pagetitle']?></h1>
				        </div>
				    </div>
				</div>
				                            
				<div class="panel-body">
				    <div class="row" role="contentinfo">
				        <div class="col-md-12">
					        <?=$page['pagecontent']?>
				        </div>
				        
				        <? if(isset($page['children'])&&!empty($page['children'])): ?>
				        	<div class="col-md-12">
					        	<div id="accordion" class="panel-group">
								    <?foreach($page['children'] as $key => $item):?>
								    <div class="panel panel-default">
									    <div class="panel-heading">
									      <h4 class="panel-title">
									        <a data-toggle="collapse" data-target="#question_<?=$item['_id']['$id']?>" data-parent="#accordion">
										        <?=$item['pagetitle']?>
									        </a>
									      </h4>
									    </div>
									    <div id="question_<?=$item['_id']['$id']?>" class="panel-collapse collapse">
									      <div class="panel-body">
										      <?=html_entity_decode($item['pagecontent'])?>
									      </div>
									    </div>
								    </div>
								    <?endforeach;?>
								</div>
				        	</div>
				        <? endif; ?>
				        <div class="col-md-12">
					        <div class="panel text-center">
						        <a href="#" class="btn btn-primary btn-lg" id="add_question" data-toggle="modal" data-target="#add_question_form">Задать вопрос</a>
					        </div>
				        </div>
				    </div>
				</div>
                
            </div>
        </div>
    </div>
</div>

<?endif;?>

<!--noindex-->

<div id="add_question_form" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Задать свой вопрос</h4>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal">
                    <div class="form-group">
                        <label for="username" class="col-sm-3 control-label">Ваше имя</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="username" placeholder="Введите свое имя">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="useremail" class="col-sm-3 control-label">Ваш Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="useremail" placeholder="Введите контактный Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="useremsg" class="col-sm-3 control-label">Ваш вопрос</label>
                        <div class="col-sm-9">
                            <textarea rows="5" class="form-control" id="useremsg" placeholder="Введите контактный Email"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-primary">Отправить</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!--/noindex-->