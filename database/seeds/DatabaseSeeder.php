<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Schema::disableForeignKeyConstraints();
    	$this->call([
            MasterMonthSeeder::class,
            MasterCountrySeeder::class,
            MasterStateSeeder::class,
            MasterDistrictSeeder::class,
            MasterPostcodeSeeder::class,

    		MasterUserStatusSeeder::class,
    		MasterUserTypeSeeder::class,
    		MasterFilingStatusSeeder::class,
            MasterProvinceOfficeSeeder::class,
            MasterComplaintClassificationSeeder::class,
            MasterSectorSeeder::class,
            MasterSectorCategorySeeder::class,
            MasterActivityTypeSeeder::class,
            MasterModuleSeeder::class,
            MasterConstitutionTypeSeeder::class,
            MasterConstitutionTemplateSeeder::class,

            MasterJustificationSeeder::class,
            MasterDesignationSeeder::class,
            MasterAttorneySeeder::class,
            MasterCourtSeeder::class,
            MasterProgrammeTypeSeeder::class,
            MasterRegionSeeder::class,
            MasterMeetingTypeSeeder::class,
            MasterUnionTypeSeeder::class,
            MasterFederationTypeSeeder::class,
            MasterIndustryTypeSeeder::class,
            MasterAnnouncementTypeSeeder::class,
            MasterLetterTypeSeeder::class,
            MasterAddressTypeSeeder::class,

            MasterInboxStatusSeeder::class,
            MasterHolidayTypeSeeder::class,
            MasterPartyTypeSeeder::class,
            MasterReferenceTypeSeeder::class,
            MasterChangeTypeSeeder::class,

            MasterReportTypeSeeder::class,
            MasterReportSeeder::class,

    		RoleSeeder::class,
    		UserSeeder::class,
            NotificationSeeder::class,
    	]);
        Schema::enableForeignKeyConstraints();
    }
}
