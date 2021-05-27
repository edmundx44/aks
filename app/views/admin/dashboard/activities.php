<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>

    <script type="text/javascript" src="<?=PROOT?>vendors/js/activities.js"></script> 
    <link rel="stylesheet" href="<?=PROOT?>vendors/css/activities.css" media="screen" title="no title" charset="utf-8">

<?php $this->end(); ?>
<?php $this->start('body')?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 mtop-35px">
            <div class="card card-style card-normalmode">
                <div class="card-body no-padding" style=""   > 
                    <div class="card-div-overflow-style row-1-card-div-overflow-style-1 content-title-div">
                       <p class="content-title-p-1">Recently Created</p>
                       <p class="content-title-p-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                    <div class="activities-content">
                        <div class="filter-activities">

                            <span class="ac-add-filter"><i class="fas fa-plus-square"></i> &nbsp; <span class="ac-add-filter-span">Add Filter</span></span>
                            <a href="/aks/dashboard/employeeTable" class="btn btn-success float-right">Price Team</a>
                            
                            <div class="filter-functions">

                                <div class="dropdown filter-function-dd">
                                    <button class="btn btn-primary dropdown-toggle filter-btn" data-toggle="dropdown">
                                        <span class="float-left select-btn-team">Select Team's</span>
                                    </button>
                                    <div class="dropdown-menu select-btn-team-dm">
                                        <span class="dropdown-item act-dropdown select-btn-team-di" data-whatni="">All</span>
                                        <span class="dropdown-item act-dropdown select-btn-team-di" data-whatni="bots_team">Bot's team</span>
                                        <span class="dropdown-item act-dropdown select-btn-team-di" data-whatni="developer">Developer's</span>
                                        <span class="dropdown-item act-dropdown select-btn-team-di" data-whatni="price">Price team</span>
                                     </div>
                                </div>

                                <div class="dropdown filter-function-dd">
                                    <button class="btn btn-primary dropdown-toggle filter-btn" data-toggle="dropdown">
                                        <span class="float-left select-btn-employee">Employee</span>
                                    </button>
                                    <div class="dropdown-menu select-btn-employee-dm scrollbar-custom">
                                        <!-- dynamic data here from database -->
                                     </div>
                                </div>

                                <div class="dropdown filter-function-dd">
                                    <button class="btn btn-primary dropdown-toggle filter-btn" data-toggle="dropdown">
                                        <span class="float-left select-btn-action">Action</span>
                                    </button>
                                    <div class="dropdown-menu select-btn-action-dm">
                                        <span class="dropdown-item act-dropdown select-btn-action-di" data-action="created">Create</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" data-action="modified">Modified</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" data-action="opens">Opens</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" data-action="changed_price">Changed Price</span>
                                        <span class="dropdown-item act-dropdown select-btn-action-di" data-action="deleted">Deleted</span>
                                     </div>
                                </div>

                                <div class="dropdown filter-function-dd">
                                    <button class="btn btn-primary dropdown-toggle filter-btn" data-toggle="dropdown">
                                        <span class="float-left select-btn-site">Site</span>
                                    </button>
                                    <div class="dropdown-menu select-btn-site-dm">
                                        <span class="dropdown-item act-dropdown select-btn-site-di" data-site="aks">AKS</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" data-site="cdd">CDD</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" data-site="brexitgbp">BREX</span>
                                     </div>
                                </div>

                                <div class="filter-function-dd">
                                    <button class="btn btn-success" id="activities-submit-filter">Submit</button>
                                </div>
                            </div>
                        </div>

                        <div class="display-activities-content"> 
                            <table class="col-12">
                                <thead>
                                    <tr class="dac-tr">
                                        <th class="dac-tr-head">Date</th>
                                        <th class="dac-tr-head">Employee</th>
                                        <th class="dac-tr-head">Action</th>
                                        <th class="dac-tr-head dac-tr-head-width hide-on-smmd-lg">Game ID</th>
                                        <th class="dac-tr-head hide-on-smmd-lg">Link</th>
                                        <th class="dac-tr-head hide-on-smmd-lg">Site</th>
                                    </tr> 
                                </thead>
                                <tbody id="recent-activity-body">
                                    <!-- dynamic data here from database -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end()?>

