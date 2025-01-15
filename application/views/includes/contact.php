<div class="page-section" id="contacts">
      <div class="container">
          <div class="text-center wow fadeInUp">
        <h3 style="padding-top: 50px" class="section-subtitle"><?=$this->lang->line('contact_title')?></h3>
      </div>
      <div class="row text-center align-items-center">
        <div class="col-lg-3 py-3">
          <div class="display-4 text-center text-primary"><i style="color: #F15F43" class="fa fa-map-pin"></i></div>
          <span class="mb-3 font-weight-medium text-lg"><?=$this->lang->line('contact_adresse')?></span><br>
          <span class="mb-0 text-secondary"><?=$this->lang->line('contact_adress_detail')?></span>
        </div>
        <div class="col-lg-3 py-3">
          <div class="display-4 text-center text-primary"><i style="color: #F15F43" class="fa fa-clock-o"></i></div>
          <span class="mb-3 font-weight-medium text-lg"><?=lang('contact_heure_ouverture_title')?></span><br>
          <span class="mb-0 text-secondary"><?=lang('contact_heure_ouverture')?> </span>
        </div>
        <div class="col-lg-3 py-3">
          <div class="display-4 text-center text-primary"><i style="color: #F15F43" class="fa fa-phone"></i></div>
          <span class="mb-3 font-weight-medium text-lg"><?=$this->lang->line('contact_telephone')?></span><br>
          <span class="mb-0"><a href="#" class="text-secondary"><?=$this->config->item('info_tel')?></a></span>
        </div>

        <div class="col-lg-3 py-3">
          <a href="mailto:<?=$this->config->item('info_email')?>" class="text-secondary">
          <div class="display-4 text-center text-primary"><i class="contact-icon fa fa-envelope"></i></div>
          <span class="mb-3 font-weight-medium text-lg"><?=$this->lang->line('contact_email')?></span><br>
          <span class="mb-0">contact@migration.gov.bi</span>
        </a></div>
      </div>
    </div>
    </div>