<?php if ($pagination_data['total'] > 10): ?>
    <div class='pagination_nav'>
        <p>Всего материалов по вашему запросу:&nbsp;<span class="total"><?= $pagination_data['total'] ?>.</span>
            <?= $pagination_data['page_nav_links'] ?> 
            &nbsp;&nbsp;<span class="num">Показывать по:
                <select name="num" id="num" class="short">
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
        function renum()
        {
            var num = $("#num").val();
    	
            $.ajax({
                type: "POST",
                data: "num=" + num,
                url: "/ajax/renum",
                dataType: "json",
                success: function(data)
                {
                    if(data.result)
                    {
                        location.replace("/<? print Request::current()->directory() ?>/<? print Request::current()->controller() ?>/<? print Request::current()->action() ?>/<? print Request::current()->param('cat') ?>");
                    }
                }
            })
        }

        $(document).ready(function(){
            $("#num").change(renum);
        });
    </script>
<?php endif; ?>