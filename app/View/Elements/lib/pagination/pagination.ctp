<?php
if ($this->Paginator->param('pageCount') > 1) { ?>

    <?php
    $urlReplace = array_key_exists('page', $this->passedArgs) ? 'page:' . $this->passedArgs['page'] : null;
    $url = empty($urlReplace) ? AdditionalComponent::url() . '/{page}' : str_replace($urlReplace, '{page}', AdditionalComponent::url());
    $prev = ($this->Paginator->param('page') - 1 > 0) ? str_replace('{page}', 'page:' . ($this->Paginator->param('page') - 1), $url) : null;
    $next = ($this->Paginator->param('page') + 1 <= $this->Paginator->param('pageCount')) ? str_replace('{page}', 'page:' . ($this->Paginator->param('page') + 1), $url) : null;
    ?>

    <h5 style="display: inline; margin-right: 4px;">
        <?php echo $this->Paginator->counter('<span class="b3">Pg.</span> <span class="b">{:page}~{:pages}, <span class="b3">Rg.</span> {:count}</span>'); ?>
    </h5>

    <a style="margin: 1px -5px 0 0; padding-bottom: 10px;" <?php echo $prev ? 'href="' . $prev . '"' : ''; ?> class="ui button mini icon <?php echo $prev ? '' : 'disabled'; ?>">
        <i class="icon left"></i>
    </a>

    <span class="ui form small">
        <div class="input mini jPaginatorSubmit" style="width: 52px;">
            <input type="text" class="no radius text center" placeholder="Nª" style="padding-bottom: 8px;">
        </div>
    </span>

    <a style="margin: 1px 0 0 -5px; padding-bottom: 10px;" <?php echo $next ? 'href="' . $next . '"' : ''; ?> class="ui button mini icon  <?php echo $next ? '' : 'disabled'; ?>">
        <i class="icon right"></i>
    </a>

    <script>
        (function($) {
            var $SetCustomPage = {
                element: ".jPaginatorSubmit",
                page: "<?php echo $this->Paginator->param('page'); ?>",
                url: "<?php echo $url; ?>",
                count: "<?php echo $this->Paginator->param('pageCount'); ?>",
                //
                initialize: function() {
                    $('input', $($SetCustomPage.element)).val($SetCustomPage.page)
                },
                role: function() {
                    Validate.input.onlyNumber($($SetCustomPage.element))
                },
                fail: function($on, $function) {
                    $($SetCustomPage.element).on($on, $function)
                }
            }

            $SetCustomPage.initialize()
            $SetCustomPage.role()
            $SetCustomPage.fail("keypress", function($e) {
                $value = parseInt($('input', $(this)).val())
                if ($e.which == 13) {
                    if ($value == $SetCustomPage.page) {
                        $($SetCustomPage.element).removeClass('error')
                        $($SetCustomPage.element).css('border', '2px solid #d9edf7')
                    } else if (!$.isNumeric($value) || $value == "" || $value < 1 || $value > $SetCustomPage.count) { //Validation.empty($value) ||
                        $($SetCustomPage.element).css('border', '2px solid #f2dede')
                        $(this).addClass('error')
                    } else {
                        window.location.href = $SetCustomPage.url.replace('{page}', 'page:' + $value)
                    }
                }
            })
        })(jQuery);
    </script>
<?php } else { ?>
    <small class="mini text l">
        Página única
    </small>
<?php } ?>