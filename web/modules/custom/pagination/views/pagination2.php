<?php if ($pagination_data['total'] > 10): ?>
    <div class='pagination_nav'>
        <p>Всего материалов по вашему запросу:&nbsp;&nbsp;<span class="total"><?= $pagination_data['total'] ?>.</span>
            <?= $pagination_data['page_nav_links'] ?> 
            &nbsp;&nbsp;&nbsp;<span class="num">Показывать по:
                <select name="num" id="num2" class="short">
                    <?php foreach ($num_in_page as $value): ?>
                        <?php if ($value == $pagination_data['num']): ?>
                            <option value="<?= $value ?>" selected='selected'><?= $value ?></option>
                        <?php else: ?>
                            <option value="<?= $value ?>"><?= $value ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select></span>
        </p>
    </div>
    <script type="text/javascript">
        function renum2()
        {
            var num = $("#num2").val();
    	
            $.ajax({
                type: "POST",
                data: "num=" + num,
                url: "/ajax/renum",
                dataType: "json",
                success: function(data)
                {
                    if(data.result)
                    {
                        location.replace("/<? print Request::current()->action() ?>/<? print Request::current()->param('cat') ?>");
                    }
                }
            })
        }

        $(document).ready(function(){
            $("#num2").change(renum2);
        });
    </script>
<?php endif; ?>