<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewReportTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Public = Orange
        // Internal = Blue

        /* 1. Number of Unions and Membership 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public1');
        DB::statement('CREATE VIEW view_report_public1 AS
        SELECT
        	YEAR(n.applied_at) AS year,
        	COUNT(n.created_by_user_id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM formn n
        JOIN user u ON n.created_by_user_id = u.id
        JOIN formb b ON u.id = b.created_by_user_id
        JOIN user_union un ON b.user_union_id = un.id
        WHERE n.filing_status_id = 9
        GROUP BY YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 2. Number of Unions By Gender 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public2');
        DB::statement('CREATE VIEW view_report_public2 AS
        SELECT
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(n.total_male) AS male,
        	SUM(n.total_female) AS female,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM formn n
        JOIN user u ON n.created_by_user_id = u.id
        JOIN formb b ON u.id = b.created_by_user_id
        JOIN user_union un ON b.user_union_id = un.id
        WHERE n.filing_status_id = 9
        GROUP BY YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 3. Number of Unions By Sector 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public3');
        DB::statement('CREATE VIEW view_report_public3 AS
        SELECT
        	s.id AS sector,
        	YEAR(un.registered_at) AS year,
        	COUNT(un.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_sector s
        JOIN formb b ON s.id = b.sector_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        GROUP BY s.id, YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 4. Number of Unions By Gender And Sector 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public4');
        DB::statement('CREATE VIEW view_report_public4 AS
        SELECT
        	s.id AS sector,
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(total_male) AS male,
        	SUM(total_female) AS female,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_sector s
        JOIN formb b ON s.id = b.sector_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY s.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 5. Number of Unions By Type 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public5');
        DB::statement('CREATE VIEW view_report_public5 AS
        SELECT
        	b.is_national AS type,
        	YEAR(un.registered_at) AS year,
        	COUNT(un.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user u
        JOIN formb b ON u.id = b.created_by_user_id
        JOIN user_union un ON b.user_union_id = un.id
        GROUP BY type, YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 6. Number of Unions By Type And Gender 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public6');
        DB::statement('CREATE VIEW view_report_public6 AS
        SELECT
        	b.is_national AS type,
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(n.total_male) AS male,
        	SUM(n.total_female) AS female,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user u
        JOIN formb b ON u.id = b.created_by_user_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY type, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 7. Number of Unions By Category 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public7');
        DB::statement('CREATE VIEW view_report_public7 AS
        SELECT
        	c.id AS category,
        	YEAR(un.registered_at) AS year,
        	COUNT(un.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_sector_category c
        JOIN formb b ON c.id = b.sector_category_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        GROUP BY c.id, YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 8. Number of Unions And Membership By State 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public8');
        DB::statement('CREATE VIEW view_report_public8 AS
        SELECT
        	st.id AS state,
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN view_user_last_address la ON la.entity_id = u.entity_id AND la.entity_type = u.entity_type
        JOIN address a ON la.address_id = a.id
        JOIN master_state st ON a.state_id = st.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY st.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 9. Number of Unions By Industry 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public9');
        DB::statement('CREATE VIEW view_report_public9 AS
        SELECT
        	i.id AS industry,
        	YEAR(un.registered_at) AS year,
        	COUNT(un.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_industry_type i
        JOIN user_union un ON i.id = un.industry_type_id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        GROUP BY i.id, YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 10. Membership of Unions By Industry 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public10');
        DB::statement('CREATE VIEW view_report_public10 AS
        SELECT
        	i.id AS industry,
        	YEAR(n.applied_at) AS year,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_industry_type i
        JOIN user_union un ON i.id = un.industry_type_id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY i.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 11. Number And Membership of Unions Of Employee And Employer 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public11');
        DB::statement('CREATE VIEW view_report_public11 AS
        SELECT
        	YEAR(n.applied_at) AS year,
        	t.id AS type,
        	COUNT(un.id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_union_type t
        JOIN formb b ON t.id = b.union_type_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY t.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 12. Number of Unions Affiliated with CUEPACS 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public12');
        DB::statement('CREATE VIEW view_report_public12 AS
        SELECT
        	YEAR(f.registered_at) AS year,
        	COUNT(un.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN formo o ON un.id = o.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN user_federation f ON un.user_federation_id = f.id
        WHERE o.filing_status_id = 9
        AND f.name LIKE "%CUEPACS%"
        GROUP BY YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 13. Number of Unions Affiliated with MTUC 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public13');
        DB::statement('CREATE VIEW view_report_public13 AS
        SELECT
        	YEAR(f.registered_at) AS year,
        	COUNT(un.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN formo o ON un.id = o.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN user_federation f ON un.user_federation_id = f.id
        WHERE o.filing_status_id = 9
        AND f.name LIKE "%MTUC%"
        GROUP BY YEAR(o.created_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 14. Number of Unions Affiliated with International Consultative 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public14');
        DB::statement('CREATE VIEW view_report_public14 AS
        SELECT
        	YEAR(w.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formw w ON u.id = w.created_by_user_id
        WHERE w.filing_status_id = 9
        GROUP BY YEAR(w.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 15. Number and Membership of CUEPACS 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public15');
        DB::statement('CREATE VIEW view_report_public15 AS
        SELECT
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        JOIN user_federation f ON un.user_federation_id = f.id
        WHERE n.filing_status_id = 9
        AND f.name LIKE "%CUEPACS%"
        GROUP BY YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 16. Number of Unions with Foreign Workers Membership 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public16');
        DB::statement('CREATE VIEW view_report_public16 AS
        SELECT
        	COUNT(un.id) AS unions,
        	YEAR(e.applied_at) AS year,
            SUM(pb.foreign_male + pb.foreign_female) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM enforcement_pbp2 pb
        JOIN enforcement e ON pb.enforcement_id = e.id
        JOIN user_union un ON e.entity_id = un.id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        WHERE e.filing_status_id = 9
        GROUP BY YEAR(e.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 17. Number of Unions with Foreign Workers Membership By Industry 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public17');
        DB::statement('CREATE VIEW view_report_public17 AS
        SELECT
        	i.id AS industry,
        	COUNT(un.id) AS unions,
        	YEAR(e.applied_at) AS year,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM enforcement_pbp2 pb
        JOIN enforcement e ON pb.enforcement_id = e.id
        JOIN user_union un ON e.entity_id = un.id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN master_industry_type i ON un.industry_type_id = i.id
        WHERE e.filing_status_id = 9
        GROUP BY i.id, YEAR(e.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 18. Foreign Workers Membership By Industry 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public18');
        DB::statement('CREATE VIEW view_report_public18 AS
        SELECT
        	i.id AS industry,
        	SUM(pb.foreign_male + pb.foreign_female) AS membership,
        	YEAR(e.applied_at) AS year,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM enforcement_pbp2 pb
        JOIN enforcement e ON pb.enforcement_id = e.id
        JOIN user_union un ON e.entity_id = un.id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN master_industry_type i ON un.industry_type_id = i.id
        WHERE e.filing_status_id = 9
        GROUP BY i.id, YEAR(e.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 19. Number of Unions with Foreign Workers Membership By Category 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public19');
        DB::statement('CREATE VIEW view_report_public19 AS
        SELECT
        	c.id AS category,
        	COUNT(un.id) AS unions,
        	YEAR(e.applied_at) AS year,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM enforcement_pbp2 pb
        JOIN enforcement e ON pb.enforcement_id = e.id
        JOIN user_union un ON e.entity_id = un.id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN master_sector_category c ON b.sector_category_id = c.id
        WHERE e.filing_status_id = 9
        GROUP BY c.id, YEAR(e.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 20. Foreign Workers Membership By State 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public20');
        DB::statement('CREATE VIEW view_report_public20 AS
        SELECT
        	st.id AS state,
        	SUM(pb.foreign_male + pb.foreign_female) AS membership,
        	YEAR(e.applied_at) AS year,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM enforcement_pbp2 pb
        JOIN enforcement e ON pb.enforcement_id = e.id
        JOIN user_union un ON e.entity_id = un.id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN view_user_last_address la ON la.entity_id = u.entity_id AND la.entity_type = u.entity_type
        JOIN address a ON la.address_id = a.id
        JOIN master_state st ON a.state_id = st.id
        JOIN master_sector_category c ON b.sector_category_id = c.id
        WHERE e.filing_status_id = 9
        GROUP BY st.id, YEAR(e.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 21. Foreign Workers Membership By Country of Origin 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_public21');
        DB::statement('CREATE VIEW view_report_public21 AS
        SELECT
        	SUM(a.total_indonesian_male + a.total_indonesian_female) AS Indonesia,
        	SUM(a.total_vietnamese_male + a.total_vietnamese_female) AS Vietnam,
        	SUM(a.total_philippines_male + a.total_philippines_female) AS Filipina,
        	SUM(a.total_myanmar_male + a.total_myanmar_female) AS Myanmar,
        	SUM(a.total_cambodia_male + a.total_cambodia_female) AS Kemboja,
        	SUM(a.total_bangladesh_male + a.total_bangladesh_female) AS Bangladesh,
        	SUM(a.total_india_male + a.total_india_female) AS India,
        	SUM(a.total_nepal_male + a.total_nepal_female) AS Nepal,
        	SUM(a.total_others_male + a.total_others_female) AS other_countries,
        	YEAR(e.applied_at) AS year,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM enforcement_a5 a
        JOIN enforcement e ON a.enforcement_id = e.id
        JOIN user_union un ON e.entity_id = un.id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        WHERE e.filing_status_id = 9
        GROUP BY YEAR(e.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        ////////////////////////////////////////////////////////////////////////////////////////////////////

        /* 1. Number Of Trade Unions & Membership */
        DB::statement('DROP VIEW IF EXISTS view_report_internal1');
        DB::statement('CREATE VIEW view_report_internal1 AS
        SELECT
        	YEAR(n.applied_at) AS year,
        	COUNT(n.created_by_user_id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM formn n
        JOIN user u ON n.created_by_user_id = u.id
        JOIN formb b ON u.id = b.created_by_user_id
        JOIN user_union un ON b.user_union_id = un.id
        WHERE n.filing_status_id = 9
        GROUP BY YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 2. Number Of Trade Unions Membership By Gender */
        DB::statement('DROP VIEW IF EXISTS view_report_internal2');
        DB::statement('CREATE VIEW view_report_internal2 AS
        SELECT
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(n.total_male) AS male,
        	SUM(n.total_female) AS female,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM formn n
        JOIN user u ON n.created_by_user_id = u.id
        JOIN formb b ON u.id = b.created_by_user_id
        JOIN user_union un ON b.user_union_id = un.id
        WHERE n.filing_status_id = 9
        GROUP BY YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 3. Numbers Of Trade Unions & Membership By Sector */
        DB::statement('DROP VIEW IF EXISTS view_report_internal3');
        DB::statement('CREATE VIEW view_report_internal3 AS
        SELECT
        	s.id AS sector,
        	YEAR(un.registered_at) AS year,
        	COUNT(un.id) AS unions,
            SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_sector s
        JOIN formb b ON s.id = b.sector_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON un.id = u.entity_id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE u.entity_type LIKE "%Union"
        GROUP BY s.id, YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 4. Numbers Of Trade Unions Membership Of By Sector And Gender Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal4');
        DB::statement('CREATE VIEW view_report_internal4 AS
        SELECT
        	s.id AS sector,
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(total_male) AS male,
        	SUM(total_female) AS female,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_sector s
        JOIN formb b ON s.id = b.sector_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY s.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 5. Number Of Trade Unions By Type */
        DB::statement('DROP VIEW IF EXISTS view_report_internal5');
        DB::statement('CREATE VIEW view_report_internal5 AS
        SELECT
        	b.is_national AS type,
        	YEAR(un.registered_at) AS year,
        	COUNT(un.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM formb b
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        GROUP BY type, YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 6. Number Of Trade Unions Membership By Type And Gender Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal6');
        DB::statement('CREATE VIEW view_report_internal6 AS
        SELECT
        	b.is_national AS type,
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(n.total_male) AS male,
        	SUM(n.total_female) AS female,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM formb b
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY type, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 7. Number of Unions & Membership By Etoi Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal7');
        DB::statement('CREATE VIEW view_report_internal7 AS
        SELECT
        	c.id AS category,
        	YEAR(n.applied_at) AS year,
        	COUNT(n.created_by_user_id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_sector_category c
        JOIN formb b ON c.id = b.sector_category_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        AND c.sector_id = 2
        GROUP BY c.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 8. Number of Employees and Employers Unions Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal8');
        DB::statement('CREATE VIEW view_report_internal8 AS
        SELECT
        	t.id AS type,
        	YEAR(un.registered_at) AS year,
        	COUNT(un.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_union_type t
        JOIN formb b ON t.id = b.union_type_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        GROUP BY t.id, YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 9. List of Employers Unions & Membership Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal9');
        DB::statement('CREATE VIEW view_report_internal9 AS
        SELECT
        	YEAR(n.applied_at) AS year,
            un.id,
        	un.name,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_union_type t
        JOIN formb b ON t.id = b.union_type_id
        JOIN user_union un ON b.user_union_id = un.id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        AND t.id = 1
        GROUP BY YEAR(n.applied_at), un.id, un.name, u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 10. Numbers Of Trade Unions & Membership By State Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal10');
        DB::statement('CREATE VIEW view_report_internal10 AS
        SELECT
        	st.id AS state,
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN view_user_last_address la ON la.entity_id = u.entity_id AND la.entity_type = u.entity_type
        JOIN address a ON la.address_id = a.id
        JOIN master_state st ON a.state_id = st.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY st.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 11. Highest Number of Unions Membership Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal11');
        DB::statement('CREATE VIEW view_report_internal11 AS
        SELECT
        	YEAR(n.applied_at) AS year,
            un.id,
        	un.name,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY YEAR(n.applied_at), un.id, un.name, u.entity_type, u.entity_id, b.sector_id, b.sector_category_id
        ORDER BY membership DESC;');

        /* 12. Number of Registered & Active Unions By Location */
        DB::statement('DROP VIEW IF EXISTS view_report_internal12');
        DB::statement('CREATE VIEW view_report_internal12 AS
        SELECT
        	YEAR(un.registered_at) AS year,
        	(CASE
        		WHEN b34.workplace = "SARAWAK" THEN 2
        		WHEN b34.workplace = "SABAH" THEN 1
        		ELSE 0
        	END) AS location,
        	COUNT(n.created_by_user_id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN (
        	SELECT formb_id, workplace
        	FROM formb3 b3
        	UNION
        	SELECT formb_id, workplace
        	FROM formb4 b4) b34 ON b.id = b34.formb_id
        JOIN formn n ON u.id = n.created_by_user_id
        GROUP BY YEAR(un.registered_at), location, u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 13. Number of Active Unions */
        DB::statement('DROP VIEW IF EXISTS view_report_internal13');
        DB::statement('CREATE VIEW view_report_internal13 AS
        SELECT
        	YEAR(un.registered_at) AS year,
        	COUNT(u.id) AS unions,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user u
        JOIN formb b ON u.id = b.created_by_user_id
        JOIN user_union un ON b.user_union_id = un.id
        WHERE u.user_status_id = 1
        AND u.user_type_id = 3
        GROUP BY YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 14. Number of Merged Unions with CUEPACS, MTUC, & International Consultative Bodies Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal14');
        DB::statement('CREATE VIEW view_report_internal14 AS
        SELECT
        	mrg.type,
        	YEAR(n.applied_at) AS year,
        	COUNT(n.created_by_user_id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        JOIN (
            SELECT
        		un.id,
        		(CASE
        			WHEN (f.name LIKE "%CUEPACS%") THEN 0
        			WHEN (f.name LIKE "%MTUC%") THEN 1
        		END) AS type
        	FROM user_union un
        	JOIN user_federation f ON un.user_federation_id = f.id
        	WHERE f.name LIKE "%CUEPACS%"
        	OR f.name LIKE "%MTUC%"
        	UNION ALL
        	SELECT
        		un.id,
        		(CASE
        			WHEN (w.filing_status_id = 9) THEN 2
        		END) AS type
        	FROM user_union un
        	JOIN user u ON un.id = u.entity_id
        	JOIN formw w ON u.id = w.created_by_user_id
        	WHERE w.filing_status_id = 9
        	AND u.entity_type LIKE "%Union") mrg ON un.id = mrg.id
        WHERE n.filing_status_id = 9
        GROUP BY mrg.type, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id,
        b.sector_category_id;');

        /* 15. Numbers & Membership Of Merged Trade Unions With Cuepacs Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal15');
        DB::statement('CREATE VIEW view_report_internal15 AS
        SELECT
        	st.id AS state,
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN view_user_last_address la ON la.entity_id = u.entity_id AND la.entity_type = u.entity_type
        JOIN address a ON la.address_id = a.id
        JOIN master_state st ON a.state_id = st.id
        JOIN formn n ON u.id = n.created_by_user_id
        JOIN user_federation f ON un.user_federation_id = f.id
        WHERE n.filing_status_id = 9
        AND f.name LIKE "%CUEPACS%"
        GROUP BY st.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 16. Numbers & Membership Of Merged Trade Unions With Mtuc Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal16');
        DB::statement('CREATE VIEW view_report_internal16 AS
        SELECT
        	st.id AS state,
        	YEAR(n.applied_at) AS year,
        	COUNT(un.id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN view_user_last_address la ON la.entity_id = u.entity_id AND la.entity_type = u.entity_type
        JOIN address a ON la.address_id = a.id
        JOIN master_state st ON a.state_id = st.id
        JOIN formn n ON u.id = n.created_by_user_id
        JOIN user_federation f ON un.user_federation_id = f.id
        WHERE n.filing_status_id = 9
        AND f.name LIKE "%MTUC%"
        GROUP BY st.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 17. Number of Unions & Membership By Industry */
        DB::statement('DROP VIEW IF EXISTS view_report_internal17');
        DB::statement('CREATE VIEW view_report_internal17 AS
        SELECT
        	i.id AS industry,
        	YEAR(n.applied_at) AS year,
        	COUNT(n.created_by_user_id) AS unions,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM master_industry_type i
        JOIN user_union un ON i.id = un.industry_type_id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY i.id, YEAR(n.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 18. List of Federal Unions Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal18');
        DB::statement('CREATE VIEW view_report_internal18 AS
        SELECT
        	YEAR(n.applied_at) AS year,
        	f.id,
            f.name,
        	f.registration_no,
        	f.registered_at,
        	SUM(n.total_member_end) AS membership,
        	u.entity_type,
        	u.entity_id,
        	f.industry_type_id,
        	bb.sector_id,
        	bb.sector_category_id,
        	f.province_office_id
        FROM user_federation f
        JOIN formbb bb ON f.id = bb.user_federation_id
        JOIN user u ON bb.created_by_user_id = u.id
        JOIN formn n ON u.id = n.created_by_user_id
        WHERE n.filing_status_id = 9
        GROUP BY f.id, f.name, f.registration_no, f.registered_at, YEAR(n.applied_at), u.entity_type, u.entity_id, bb.sector_id, bb.sector_category_id;');

        /* 19. List of Amalgamation Unions Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal19');
        // DB::statement('CREATE VIEW view_report_internal20 AS ');

        /* 20. Number & Foreign Worker Membership of Unions Until 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal20');
        DB::statement('CREATE VIEW view_report_internal20 AS
        SELECT
        	COUNT(un.id) AS unions,
        	SUM(pb.foreign_male + pb.foreign_female) AS membership,
        	YEAR(e.applied_at) AS year,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM enforcement_pbp2 pb
        JOIN enforcement e ON pb.enforcement_id = e.id
        JOIN user_union un ON e.entity_id = un.id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN master_sector_category c ON b.sector_category_id = c.id
        WHERE e.filing_status_id = 9
        GROUP BY YEAR(e.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 21. Number Of Trade Unions (Registration, Cancellation, Dissolution) */
        DB::statement('DROP VIEW IF EXISTS view_report_internal21');
        DB::statement('CREATE VIEW view_report_internal21 AS
        SELECT
        	YEAR(un.registered_at) AS year,
        	COUNT(un.id) AS Daftar,
        	COUNT(f.id) AS Batal,
        	COUNT(d.id) AS Bubar,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM user_union un
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        LEFT JOIN formf f ON u.id = f.created_by_user_id
        LEFT JOIN formieu d ON u.id = d.created_by_user_id
        WHERE f.filing_status_id = 9
        OR d.filing_status_id = 9
        OR un.deleted_at IS NULL
        GROUP BY YEAR(un.registered_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');

        /* 22. List Of Union & Foreign Worker Membership By States 2012 - 2016 */
        DB::statement('DROP VIEW IF EXISTS view_report_internal22');
        DB::statement('CREATE VIEW view_report_internal22 AS
        SELECT
        	st.id AS state,
            st.name AS st_name,
            un.name AS un_name,
            un.registration_no,
        	SUM(pb.foreign_male + pb.foreign_female) AS membership,
        	YEAR(e.applied_at) AS year,
        	u.entity_type,
        	u.entity_id,
        	un.industry_type_id,
        	b.sector_id,
        	b.sector_category_id,
        	un.province_office_id
        FROM enforcement_pbp2 pb
        JOIN enforcement e ON pb.enforcement_id = e.id
        JOIN user_union un ON e.entity_id = un.id
        JOIN formb b ON un.id = b.user_union_id
        JOIN user u ON b.created_by_user_id = u.id
        JOIN master_sector_category c ON b.sector_category_id = c.id
        JOIN view_user_last_address la ON la.entity_id = u.entity_id AND la.entity_type = u.entity_type
        JOIN address a ON la.address_id = a.id
        JOIN master_state st ON a.state_id = st.id
        WHERE e.filing_status_id = 9
        GROUP BY st.id, st.name, un.id, YEAR(e.applied_at), u.entity_type, u.entity_id, b.sector_id, b.sector_category_id;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
