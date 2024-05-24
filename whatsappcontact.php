<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class WhatsAppContact extends Module
{
    public function __construct()
    {
        $this->name = 'whatsappcontact';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Moris Web';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('WhatsApp Contact');
        $this->description = $this->l('Adds a WhatsApp icon to contact support.');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayFooter') &&
            Configuration::updateValue('WHATSAPP_TOOLTIP_MESSAGE', 'Contact us on WhatsApp') &&
            Configuration::updateValue('WHATSAPP_PHONE_NUMBER', 'YOURNUMBER');
    }

    public function uninstall()
    {
        return parent::uninstall() &&
            Configuration::deleteByName('WHATSAPP_TOOLTIP_MESSAGE') &&
            Configuration::deleteByName('WHATSAPP_PHONE_NUMBER');
    }

    public function getContent()
    {
        $output = '';

        // Check if a new message and number has been sent and save them
        if (Tools::isSubmit('submitNewData')) {
            $newMessage = Tools::getValue('whatsapp_new_message');
            $newNumber = Tools::getValue('whatsapp_new_number');
            Configuration::updateValue('WHATSAPP_TOOLTIP_MESSAGE', $newMessage);
            Configuration::updateValue('WHATSAPP_PHONE_NUMBER', $newNumber);
            $output .= $this->displayConfirmation($this->l('Message and number updated correctly.'));
        }

        // Form per inserire un nuovo messaggio e numero
        $output .= '
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
            <fieldset>
                <legend>' . $this->l('Update Message and Number for Tooltip') . '</legend>
                <label>' . $this->l('New Message') . '</label>
                <div class="margin-form">
                    <input type="text" name="whatsapp_new_message" value="' . Configuration::get('WHATSAPP_TOOLTIP_MESSAGE') . '" />
                </div>
                <label>' . $this->l('Nuovo Numero') . '</label>
                <div class="margin-form">
                    <input type="text" name="whatsapp_new_number" value="' . Configuration::get('WHATSAPP_PHONE_NUMBER') . '" />
                </div>
                <input type="submit" name="submitNewData" value="' . $this->l('Salva') . '" class="button" />
            </fieldset>
        </form>';

        return $output;
    }

    public function hookDisplayFooter($params)
    {
        $whatsappMessage = Configuration::get('WHATSAPP_TOOLTIP_MESSAGE') ?: 'Contact us on WhatsApp';
        $whatsappNumber = Configuration::get('WHATSAPP_PHONE_NUMBER') ?: 'YOURNUMBER';
        $this->context->smarty->assign('whatsapp_link', 'https://wa.me/' . $whatsappNumber);
        $this->context->smarty->assign('whatsapp_message', $whatsappMessage);
        return $this->display(__FILE__, 'views/templates/hook/displayFooter.tpl');
    }
}
