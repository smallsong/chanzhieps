  <div class="span3">
    <?php $contact = json_decode($this->config->company->contact);?>
    <div class="sidebar"> 
      <div class="widget">  
        <h4><?php echo $lang->company->contactUs;?></h4>
        <hr/>
        <ul>
          <li><?php echo $lang->company->address . ':' . $contact->address;?></li>
          <li><?php echo $lang->company->phone . ':' . $contact->phone;?></li>
          <li><?php echo $lang->company->email . ':' . $contact->email;?></li>
          <li><?php echo $lang->company->fax . ':' . $contact->fax;?></li>
          <li><?php echo $lang->company->qq . ':' . $contact->qq;?></li>
        </ul>
      </div>
      <div class="widget"> 
        <h4><?php echo $lang->company->contactUs;?></h4>
        <hr/>
        <ul>
          <li><?php echo $lang->company->address . ':' . $contact->address;?></li>
          <li><?php echo $lang->company->phone . ':' . $contact->phone;?></li>
          <li><?php echo $lang->company->email . ':' . $contact->email;?></li>
          <li><?php echo $lang->company->fax . ':' . $contact->fax;?></li>
          <li><?php echo $lang->company->qq . ':' . $contact->qq;?></li>
        </ul>
      </div>
    </div>
  </div>

