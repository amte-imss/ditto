<?php
/**
 * @author Christian Garcia
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('render_menu'))
{

    function render_menu($menu = [], $dropdown = null)
    {
        $html = '';
        ob_start();
        ?>
        <ul class="nav  <?php echo ($dropdown != null ? 'collapse' : ''); ?>" <?php echo ($dropdown != null ? 'id="'.$dropdown.'" style="margin-left: 20px;"' : ''); ?>>
            <?php
            foreach ($menu as $item)
            {
                $enlace = '#';
                if(isset($item['link'])){
                    if(startsWith($item['link'], 'http://')||startsWith($item['link'], 'https://')){
                        $enlace = $item['link'];
                    }else if(empty ($item['link'])){
                        $enlace = '#';
                    }else{
                        $enlace = site_url() . $item['link'];
                    }
                }
                ?>
                <li class="<?php echo (isset($item['childs']) ? '' : '') ?>" style="list-style-type: none;">

                    <a href="<?php echo (isset($item['childs']) ? '#': $enlace); ?>" <?php echo (isset($item['childs']) ? 'data-toggle="collapse" data-target="#menu'.$item['id_menu'].'"': ' id="tablero-menu-item-'.$item['id_menu'].'" class="tablero-menu-item" '); ?>>
                        <i class="<?php echo ((isset($item['icon']) && !empty($item['icon']))?$item['icon']:'dashboard');?>"></i>
                        <?php
                        if (isset($item['titulo']))
                        {
                            ?>
                            <?php echo $item['titulo']; ?>
                            <?php
                        }
                        ?>
                    </a>
                    <?php
                    if (isset($item['childs']))
                    {
                        //pr($item['childs']);
                        echo render_menu($item['childs'], 'menu'.$item['id_menu']);
                    }
                    ?>
                </li>
            <?php } ?>
        </ul>
        <?php
        $html = ob_get_contents();
        ob_get_clean();
        return $html;
    }

}
