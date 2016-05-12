<?php echo $header; ?>

<style type="text/css">
    .network_name {
        display: inline;
        margin-left: 10px;
    }
    
    .required_hide {
        color: #999;
    }
    
    .theme_block {
        margin: 10px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
        height: 165px;
        overflow: auto;
    }
    
    .theme_block .theme_title {
        font-size: 20px;
        float: left;
    }
    
    .theme_block .btn_apply {
        float: right;
    }
    
    .theme_block .sa_frame {
        float: left;
        width: 100%;
        margin: 15px 0;
        padding: 0 3px;
    }
    
    .theme_block.active {
        border: 3px solid #1872a2;
    }
    
    .fieldset_right {
        float: right;
        font-size: 14px;
        font-weight: bold;
    }
    
    .fieldset_right input {
        margin-right: 5px;
    }
    
    .theme_block .check_theme_applied {
        float: right;
        font-size: 30px;
        color: #009900;
        line-height: 20px;
        margin-left: 15px;
    }
    
    .theme_block .theme_size {
        display: inline-block;
        margin-left: 35px;
        margin-top: 5px;
        font-size: 14px;
    }
    
    .theme_block .btn_custom {
        float: right;
        margin-right: 3px;
        background-color: #aaa;
        color: #FFF;
        border-color: #999;
    }
    
    .theme_block .btn_custom:hover {
        background-color: #999;
    }
</style>

<?php echo $column_left; ?>

<?php echo $footer; ?>