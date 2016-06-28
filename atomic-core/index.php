<?php include("head.php"); ?>
<?php
require "fllat.php";
$compdb = new Fllat("compdb");
$catdb = new Fllat("catdb");


$comp_data = $compdb->select(array());
$cat_data = $catdb->select(array());


?>
    <body class="atoms">


<div class="grid-row atoms-container">
    <div class="atoms-side_show-small ">
        <span class="toggle-line"></span>
        <span class="toggle-line"></span>
        <span class="toggle-line"></span>
    </div>
    <div class="atoms-side_show ">
        <span class="js-showSide fa fa-arrow-right"></span>
    </div>
    <aside class="atoms-side">
        <div class="atoms-overflow">

            <div class="atoms-side_hide">
                <span class="js-hideSide fa fa-arrow-left"></span>
                <span class="js-hideTitle fa fa-header"></span>
                <span class="js-hideNotes fa fa-paragraph"></span>
                <span class="js-hideCode fa fa-code"></span>
            </div>

            <nav>
                <ul class="atoms-nav">

                    <?php foreach ($cat_data as $cat_value) {

                        global $cat_value
                        ?>

                        <li class="aa_dir ">
                            <div class="aa_dir__dirNameGroup">
                                <i class="aa_dir__dirNameGroup__icon  fa fa-folder-o"></i>
                                <a class="aa_dir__dirNameGroup__name"
                                   href="atomic-core/?cat=<?php echo $cat_value['cat_name'] ?>"><?php echo $cat_value['cat_name'] ?></a>
                            </div>
                            <ul class="aa_fileSection">
                                <li class="aa_addFileItem">
                                    <a class="aa_addFile aa_js-actionOpen aa_actionBtn"
                                       href="atomic-core/categories/modules/form-modules.php">
                                        <span class="fa fa-plus"></span> Add Component</a>
                                </li>

                                <?php $filtered = array_filter($comp_data, function ($v) {
                                    global $cat_value;
                                    return $v['comp_category'] == $cat_value['cat_name'];
                                }); ?>
                                <?php foreach ($filtered as $comp_value) { ?>

                                    <li class="aa_fileSection__file"><a
                                            class="aa_js-actionOpen aa_actionBtn fa fa-pencil-square-o"
                                            href="atomic-core/categories/<?php echo $cat_value['cat_name'] ?>/form-<?php echo $comp_value['comp_name'] ?>.php"></a><a
                                            href="atomic-core/<?php echo $cat_value['cat_name'] ?>.php#box"><?php echo $comp_value['comp_name'] ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>

                    <?php } ?>
                    <li class="catAdd"><a class="aa_js-actionOpen aa_actionBtn"
                                          href="atomic-core/categories/_catActions.php"><span
                                class="fa fa-plus"></span> Add / Delete Category</a></li>
                </ul>

            </nav>


        </div>

        <div class="cat-form js-showContent"></div>


    </aside>


    <div class="atoms-main">
        <h1 id="modules" class="atomic-h1"><?php echo $_GET['cat'];?></h1>










            <?php
                $cat = $_GET['cat'];
                global $cat;
                $comp_data = array_filter($comp_data, function($v) {
                    global $cat;
                    return $v['comp_category'] == $cat;});
                usort($comp_data , function($a, $b) {
                    return $a['comp_sort_order'] - $b['comp_sort_order'];
                });
               foreach ($comp_data as $comp_value) {
            ?>

            <div class="compWrap"><span id="<?php echo $comp_value['comp_name'] ?>"
                                        class="compTitle"><?php echo $comp_value['comp_name'] ?> <span
                        class="js-hideAll fa fa-eye"></span></span>
                <p class="compNotes"><?php echo $comp_value['comp_notes'] ?> </p>
                <div class="component"
                     style="background-color:<?php echo $comp_value['comp_context_color'] ?>"><?php include($comp_value['comp_markup_path']); ?></div>
                <!--<div class="compCodeBox">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#<?php /*echo $comp_value['comp_name'] */?>-markup"
                                                                  aria-controls="box-markup" role="tab"
                                                                  data-toggle="tab">Markup</a></li>
                        <li role="presentation"><a href="#<?php /*echo $comp_value['comp_name'] */?>-css" aria-controls="box-css"
                                                   role="tab"
                                                   data-toggle="tab">scss</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active markup-display"
                             id="<?php /*echo $comp_value['comp_name'] */?>-markup"></div>
                        <div role="tabpanel" class="tab-pane" id="<?php /*echo $comp_value['comp_name'] */?>-css">
                            <pre><code class="language-css"><?php /*include($comp_value['comp_styles_path']); */?></code></pre>
                        </div>
                    </div>
                </div>-->

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#<?php echo $comp_value['comp_name'] ?>-markup-tab" aria-controls="home" role="tab" data-toggle="tab">Markup</a></li>
                        <li role="presentation"><a href="#<?php echo $comp_value['comp_name'] ?>-styles-tab" aria-controls="profile" role="tab" data-toggle="tab">Styles</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="<?php echo $comp_value['comp_name'] ?>-markup-tab"">
                            <?php $markup_file_content = file_get_contents($comp_value['comp_markup_path'], true); ?>
                            <form class="atomic-editorWrap">
                                <div class="atomic-editor" id="editor-markup-<?php echo $comp_value['comp_name'] ?>"><script> <?php echo $markup_file_content; ?></script></div>
                                <input class="new-val-input" type="hidden" name="new-markup-val" value="" />
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="<?php echo $comp_value['comp_name'] ?>-styles-tab">
                            <?php $styles_file_content = file_get_contents($comp_value['comp_styles_path'], true); ?>
                            <form class="atomic-editorWrap">
                                <div class="atomic-editor" id="editor-styles-<?php echo $comp_value['comp_name'] ?>"><script> <?php echo $styles_file_content; ?></script></div>
                                <input type="hidden" name="new-styles-val" value="" />
                            </form>
                        </div>
                    </div>

                </div>






            </div>

        <?php } ?>





    </div>
</div>
<div class="aa_js-actionDrawer aa_actionDrawer">
    <div class="aa_actionDrawer__wrap">
        <div class="aa_js-actionClose aa_actionDrawer__close"><i class="fa fa-times fa-3x"></i></div>
        <div id="js_actionDrawer__content" class="actionDrawer__content"></div>
    </div>
</div>
<?php include("footer.php"); ?>