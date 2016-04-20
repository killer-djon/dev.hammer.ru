
<!-- footer starts here -->
<footer class="footer text-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="icons">
                    <a href=""><i class="fa fa-behance"></i></a>
                    <a href=""><i class="fa fa-dribbble"></i></a>
                    <a href=""><i class="fa fa-twitter"></i></a>
                    <a href=""><i class="fa fa-facebook"></i></a>
                    <a href=""><i class="fa fa-linkedin"></i></a>
                </div>
                <p>COPYRIGHT &copy; 2016 Все права защищены</p>
            </div>
        </div>
    </div>
</footer>

<!--noindex-->

<div id="shopCount" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Добавить в корзину</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="qty">Выберите кол-во</label>
                        <div class="input-group count-detail">
					<span class="input-group-addon cart-qty cart-minus">
						<i class="fa fa-minus"></i>
					</span>
                            <input type="text" class="form-control text-right btn-number" id="qty" placeholder="1">
					<span class="input-group-addon cart-qty cart-plus">
						<i class="fa fa-plus"></i>
					</span>
					<span class="input-group-addon cart-qty cart-refresh">
						<i class="fa fa-refresh"></i>
					</span>

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-primary">Добавить в корзину</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!--/noindex-->

<!--noindex-->

<div id="sendMessage" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Уточнить наличие детали</h4>
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
                        <label for="useremsg" class="col-sm-3 control-label">Коментарий</label>
                        <div class="col-sm-9">
                            <textarea rows="3" class="form-control" id="useremsg" placeholder="Введите контактный Email"></textarea>
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