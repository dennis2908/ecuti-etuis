<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS view_user_last_address');
        DB::statement('CREATE VIEW view_user_last_address AS
        SELECT
            user.id,
            user_address.entity_type,
            user_address.entity_id,
            user_address.address_id
        FROM user
        LEFT JOIN user_address ON user_address.entity_type = user.entity_type AND user_address.entity_id = user.entity_id
            AND user_address.id = (SELECT MAX(addr.id) FROM user_address addr where addr.entity_type = user.entity_type AND addr.entity_id = user.entity_id)');

        //////////////////////////////////////////////////////////////////////////////

        DB::statement('DROP VIEW IF EXISTS view_user_distribution_ptw');
        DB::statement('CREATE VIEW view_user_distribution_ptw AS
        SELECT
            user.id,
            user_staff.province_office_id,
            distribution.filing_type,
            distribution.filing_id,
            mfs.id as filing_status_id,
            IFNULL(x.count,0) as count
        FROM user
        INNER JOIN user_staff ON user_staff.id = user.entity_id AND user_staff.role_id = 6
        CROSS JOIN distribution
        CROSS JOIN master_filing_status mfs
        LEFT JOIN (
            SELECT
                u.id,
                d.filing_type,
                d.filing_id,
                d.filing_status_id,
                count(d.filing_type) as count
            FROM user u
            INNER JOIN user_staff us ON us.id = u.entity_id AND us.role_id = 6
            LEFT JOIN distribution d on d.assigned_to_user_id = u.id
            WHERE u.entity_type = "App\\\\UserStaff" AND u.deleted_at IS NULL AND u.user_status_id = 1
            GROUP BY u.id, d.filing_type, d.filing_status_id
        ) AS x ON x.id = user.id AND x.filing_type = distribution.filing_type AND x.filing_status_id = mfs.id
        WHERE user.entity_type = "App\\\\UserStaff" AND user.deleted_at IS NULL AND user.user_status_id = 1
        GROUP BY user.id, distribution.filing_type, distribution.filing_id, mfs.id');

        DB::statement('DROP VIEW IF EXISTS view_user_distribution_ppw');
        DB::statement('CREATE VIEW view_user_distribution_ppw AS
        SELECT
            user.id,
            user_staff.province_office_id,
            distribution.filing_type,
            distribution.filing_id,
            mfs.id as filing_status_id,
            IFNULL(x.count,0) as count
        FROM user
        INNER JOIN user_staff ON user_staff.id = user.entity_id AND user_staff.role_id = 7
        CROSS JOIN distribution
        CROSS JOIN master_filing_status mfs
        LEFT JOIN (
            SELECT
                u.id,
                d.filing_type,
                d.filing_id,
                d.filing_status_id,
                count(d.filing_type) as count
            FROM user u
            INNER JOIN user_staff us ON us.id = u.entity_id AND us.role_id = 7
            LEFT JOIN distribution d on d.assigned_to_user_id = u.id
            WHERE u.entity_type = "App\\\\UserStaff" AND u.deleted_at IS NULL AND u.user_status_id = 1
            GROUP BY u.id, d.filing_type, d.filing_status_id
        ) AS x ON x.id = user.id AND x.filing_type = distribution.filing_type AND x.filing_status_id = mfs.id
        WHERE user.entity_type = "App\\\\UserStaff" AND user.deleted_at IS NULL AND user.user_status_id = 1
        GROUP BY user.id, distribution.filing_type, distribution.filing_id, mfs.id');

        DB::statement('DROP VIEW IF EXISTS view_user_distribution_pthq');
        DB::statement('CREATE VIEW view_user_distribution_pthq AS
        SELECT
            user.id,
            user_staff.province_office_id,
            distribution.filing_type,
            distribution.filing_id,
            mfs.id as filing_status_id,
            IFNULL(x.count,0) as count
        FROM user
        INNER JOIN user_staff ON user_staff.id = user.entity_id AND user_staff.role_id = 9
        CROSS JOIN distribution
        CROSS JOIN master_filing_status mfs
        LEFT JOIN (
            SELECT
                u.id,
                d.filing_type,
                d.filing_id,
                d.filing_status_id,
                count(d.filing_type) as count
            FROM user u
            INNER JOIN user_staff us ON us.id = u.entity_id AND us.role_id = 9
            LEFT JOIN distribution d on d.assigned_to_user_id = u.id
            WHERE u.entity_type = "App\\\\UserStaff" AND u.deleted_at IS NULL AND u.user_status_id = 1
            GROUP BY u.id, d.filing_type, d.filing_status_id
        ) AS x ON x.id = user.id AND x.filing_type = distribution.filing_type AND x.filing_status_id = mfs.id
        WHERE user.entity_type = "App\\\\UserStaff" AND user.deleted_at IS NULL AND user.user_status_id = 1
        GROUP BY user.id, distribution.filing_type, distribution.filing_id, mfs.id');

        DB::statement('DROP VIEW IF EXISTS view_user_distribution_pphq');
        DB::statement('CREATE VIEW view_user_distribution_pphq AS
        SELECT
            user.id,
            user_staff.province_office_id,
            distribution.filing_type,
            distribution.filing_id,
            mfs.id as filing_status_id,
            IFNULL(x.count,0) as count
        FROM user
        INNER JOIN user_staff ON user_staff.id = user.entity_id AND user_staff.role_id = 10
        CROSS JOIN distribution
        CROSS JOIN master_filing_status mfs
        LEFT JOIN (
            SELECT
                u.id,
                d.filing_type,
                d.filing_id,
                d.filing_status_id,
                count(d.filing_type) as count
            FROM user u
            INNER JOIN user_staff us ON us.id = u.entity_id AND us.role_id = 10
            LEFT JOIN distribution d on d.assigned_to_user_id = u.id
            WHERE u.entity_type = "App\\\\UserStaff" AND u.deleted_at IS NULL AND u.user_status_id = 1
            GROUP BY u.id, d.filing_type, d.filing_status_id
        ) AS x ON x.id = user.id AND x.filing_type = distribution.filing_type AND x.filing_status_id = mfs.id
        WHERE user.entity_type = "App\\\\UserStaff" AND user.deleted_at IS NULL AND user.user_status_id = 1
        GROUP BY user.id, distribution.filing_type, distribution.filing_id, mfs.id');

        //////////////////////////////////////////////////////////////////////////////////////////////////

        DB::statement('DROP VIEW IF EXISTS view_dashboard_stat1');
        DB::statement('CREATE VIEW view_dashboard_stat1 AS
        SELECT
            YEAR(a.registered_at) AS year,
            COUNT(CASE WHEN a.user_type_id = 3 THEN 1 ELSE NULL END) AS ks,
            COUNT(CASE WHEN a.user_type_id = 4 THEN 1 ELSE NULL END) AS pks
        FROM (
            SELECT uuser.user_type_id, u.id, u.registration_no, u.registered_at FROM user uuser INNER JOIN user_union u WHERE uuser.user_type_id = 3
            UNION 
            SELECT fuser.user_type_id, f.id, f.registration_no, f.registered_at FROM user fuser INNER JOIN user_federation f WHERE fuser.user_type_id = 4
        ) a
        WHERE a.registration_no IS NOT NULL
        GROUP BY year
        ORDER BY year DESC ');

        DB::statement('DROP VIEW IF EXISTS view_dashboard_stat2');
        DB::statement('CREATE VIEW view_dashboard_stat2 AS
        SELECT 
            YEAR(created_at) AS year, 
            COUNT(*) AS total
        FROM reference
        GROUP BY year
        ORDER BY year DESC');

        DB::statement('DROP VIEW IF EXISTS view_dashboard_stat3');
        DB::statement('CREATE VIEW view_dashboard_stat3 AS
        SELECT 
            s.id, s.name, 
            COUNT(u.user_status_id) AS total
        FROM user u
        JOIN master_user_status s ON u.user_status_id = s.id
        GROUP BY s.id');

        DB::statement('DROP VIEW IF EXISTS view_dashboard_stat4');
        DB::statement('CREATE VIEW view_dashboard_stat4 AS
        SELECT 
            p.id, p.name, 
            COUNT(u.entity_id) AS total
        FROM user u
        JOIN user_staff s ON u.entity_id = s.id
        JOIN master_province_office p ON s.province_office_id = p.id
        WHERE u.user_status_id = 1
        AND u.user_type_id = 2
        GROUP BY p.id');

        DB::statement('DROP VIEW IF EXISTS view_dashboard_stat5');
        DB::statement('CREATE VIEW view_dashboard_stat5 AS
        SELECT
            p.id, p.name,
            COUNT(p.id) AS total
        FROM
        (SELECT u.id, u.registration_no, u.registered_at, u.province_office_id
        FROM user_union u UNION 
        SELECT f.id, f.registration_no, f.registered_at, f.province_office_id 
        FROM user_federation f) a
        JOIN master_province_office p ON a.province_office_id = p.id
        WHERE a.registration_no IS NOT NULL
        GROUP BY p.id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
