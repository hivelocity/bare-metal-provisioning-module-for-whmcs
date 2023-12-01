<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/init.php';

    function getAllProducts($gid)
    { 

        $sql=full_query("SELECT * FROM tblproducts WHERE gid=".$gid." AND hidden=0 AND retired=0 LIMIT 4");

        $returnhtml = '<div class="row my-5" style="column-count: 4;">';
        while($data=mysql_fetch_array($sql)) { 

            $returnhtml.= '<div class="mb-3 col-md-3 col-lg d-flex align-items-stretch">';
            $returnhtml.= '<div class="card">';
            $returnhtml.= '<div class="card-body text-center" style="padding: 40px;">';
            $returnhtml.= '<img decoding="async" src="/templates/hivelocity/img/logo-intel-blue.svg" title="logo-intel-blue" alt="Intel CPU Logo" loading="lazy" width="40"><br><br>';
            $returnhtml.= '<h5>'.$data['name'];
            /*if($data['is_featured']=="1"){
                $returnhtml.='<div class="best_hosting_plan_tag">

                                <div>Best Value</div>

                            </div> ';
            }*/
            $returnhtml.= '</h5><br>'.getPrice($data['id']).'<br>';
            $descriptions =explode("\n", $data['description']);
            
            if($descriptions!="")
            {
                foreach ($descriptions as $key => $value) {

                    $returnhtml.= '<p>'.$value.'</p>';
                }
                
            }

            $returnhtml.= '<br><a href="/cart.php?a=add&pid='.$data['id'].'" class="btn btn-order-now" style="position: absolute;bottom: 0px;width: 100%;left: 0;display: block;padding: 14px;">Order Now</a>';
            $returnhtml.= '</div>';
            $returnhtml.= '</div>';
            $returnhtml.= '</div>';
        }
        $returnhtml.= '</div>';
        return $returnhtml;
    }

    function getPrice($pid)
    {
        $sql=full_query("SELECT * FROM tblpricing WHERE relid=".$pid." AND type='product'");
        $data=mysql_fetch_array($sql);
            
        return '<p><strong>$'.$data['monthly'].' / mo</strong></p>';
    }