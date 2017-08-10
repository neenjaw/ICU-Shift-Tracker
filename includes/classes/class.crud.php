<?php

class crud
{
    private $db;

    private $tbl_staff;
    private $tbl_shift_entry;
    private $tbl_role;
    private $tbl_category;
    private $tbl_assignment;

    function __construct($DB_con)
    {
        $this->db = $DB_con;

        $this->tbl_staff = 'shift_tracker_tbl_staff';
        $this->tbl_shift_entry = 'shift_tracker_tbl_shift_entry';
        $this->tbl_role = 'shift_tracker_tbl_staff_role';
        $this->tbl_category = 'shift_tracker_tbl_staff_category';
        $this->tbl_assignment = 'shift_tracker_tbl_assignment';
    }

    /*
     * CRUD --
     * CREATE FUNCTIONS
     * STAFF, ROLE, CATEGORY, SHIFT
     */
    public function createStaff($f_name, $l_name, $id_category, $is_active)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_staff." (`id`, `first_name` , `last_name`, `category`, `bool_is_active`) VALUES(NULL, :fname, :lname, :cat, :act)");
            $stmt->bindparam(":fname", $f_name);
            $stmt->bindparam(":lname", $l_name);
            $stmt->bindparam(":cat", $id_category);
            $stmt->bindparam(":act", $is_active);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function createRole($r_name)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_role." (role) VALUES(:rn)");
            $stmt->bindparam(":rn", $r_name);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function createCategory($c_name)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_category." (category) VALUES(:cn)");
            $stmt->bindparam(":cn", $c_name);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function createAssignment($a_name)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_assignment." (assignement) VALUES(:an)");
            $stmt->bindparam(":an", $a_name);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function createShiftEntry($shift_date, $staff_id, $role_id, $assignment_id, $bool_day_or_night, $bool_doubled = 0, $bool_vented = 1, $bool_new_admit = 0, $bool_very_sick = 0, $bool_code_pager = 0)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_shift_entry." (shift_date, staff_id, role_id, assignment_id, bool_doubled, bool_vented, bool_new_admit, bool_very_sick, bool_code_pager, bool_day_or_night) VALUES(:date, :sid, :rid, :aid, :bd, :bv, :bna, :bvs, :bcp, :bdon)");

            //:date, :sid, :rid, :aid, :bd, :bv, :bna, :bvs, :bcp, :bdon
            $stmt->bindparam(":date", $shift_date);
            $stmt->bindparam(":sid", $staff_id);
            $stmt->bindparam(":rid", $role_id);
            $stmt->bindparam(":aid", $assignment_id);
            $stmt->bindparam(":bd", boolean_to_int($bool_doubled));
            $stmt->bindparam(":bv", boolean_to_int($bool_vented));
            $stmt->bindparam(":bna", boolean_to_int($bool_new_admit));
            $stmt->bindparam(":bvs", boolean_to_int($bool_very_sick));
            $stmt->bindparam(":bcp", boolean_to_int($bool_code_pager));
            $stmt->bindparam(":bdon", boolean_to_int($bool_day_or_night));
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    private function booleanToInt($boolvalue)
    {
        if ($boolvalue) {
            return 1;
        } else {
            return 0;
        }
    }

    public function createNaShiftEntry($shift_date, $staff_id, $assignment_id, $bool_day_or_night)
    {
        try {
            $role_id = $this->db->query("SELECT id FROM ".$this->tbl_role." WHERE role='NA'");

            $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_shift_entry." (shift_date, staff_id, role_id, assignment_id, bool_day_or_night) VALUES(:date, :sid, :rid, :aid, :bdon)");

            $stmt->bindparam(":date", $shift_date);
            $stmt->bindparam(":sid", $staff_id);
            $stmt->bindparam(":rid", $role_id);
            $stmt->bindparam(":aid", $assignment_id);
            $stmt->bindparam(":bdon", boolean_to_int($bool_day_or_night));
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function createUcShiftEntry($shift_date, $staff_id, $assignment_id, $bool_day_or_night)
    {
        try {
            $role_id = $this->db->query("SELECT id FROM ".$this->tbl_role." WHERE role='UC'");

            $stmt = $this->db->prepare("INSERT INTO ".$this->tbl_shift_entry." (shift_date, staff_id, role_id, assignment_id, bool_day_or_night) VALUES(:date, :sid, :rid, :aid, :bdon)");

            $stmt->bindparam(":date", $shift_date);
            $stmt->bindparam(":sid", $staff_id);
            $stmt->bindparam(":rid", $role_id);
            $stmt->bindparam(":aid", $assignment_id);
            $stmt->bindparam(":bdon", boolean_to_int($bool_day_or_night));
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /*
     * CRUD --
     * READ FUNCTIONS
     * STAFF, ROLE, CATEGORY, ASSIGNMENT SHIFT ENTRY
     */

    public function getAllStaff()
    {
        $staff_array = array();

        $stmt = $this->db->prepare('SELECT '.$this->tbl_staff.'.id AS `id`, CONCAT( '.$this->tbl_staff.'.last_name, ", ", '.$this->tbl_staff.'.first_name, " (", '.$this->tbl_category.'.category, ")" ) AS `name` FROM '.$this->tbl_staff.' LEFT JOIN '.$this->tbl_category.' ON '.$this->tbl_staff.'.category = '.$this->tbl_category.'.id ORDER BY `name`');
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                $staff_array[$editRow['id']] = $editRow['name'];
            }
        }

        return $staff_array;
    }

    public function getStaffIdByName($f_name, $l_name)
    {
        $stmt = $this->db->prepare("SELECT id FROM ".$this->tbl_staff." WHERE last_name=:ln AND first_name:=fn");
        $stmt->bindparam(":fname", $f_name);
        $stmt->bindparam(":lname", $l_name);
        $stmt->execute();
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function getStaffById($id)
    {
        $stmt = $this->db->prepare("SELECT ".$this->tbl_staff.".last_name, ".$this->tbl_staff.".first_name, ".$this->tbl_category.".category
                                    FROM ".$this->tbl_staff."
                                    LEFT JOIN ".$this->tbl_category." on ".$this->tbl_staff.".category = ".$this->tbl_category.".id
                                    WHERE ".$this->tbl_staff.".id=:sid");
        $stmt->bindparam(":sid", $id);
        $stmt->execute();
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function getAllRoles()
    {
        $role_array = array();

        $stmt = $this->db->prepare("SELECT * FROM ".$this->tbl_role."");
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                $role_array[$editRow['id']] = $editRow['role'];
            }
        }

        return $role_array;
    }

    public function getRoleById($id)
    {
        $stmt = $this->db->prepare("SELECT role FROM ".$this->tbl_role." WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function getRoleNameById($id)
    {
        return ($this->getRoleById($id))["role"];
    }

    public function getAllCateories()
    {
        $cat_array = array();

        $stmt = $this->db->prepare("SELECT * FROM ".$this->tbl_category."");
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                $cat_array[$editRow['id']] = $editRow['category'];
            }
        }

        return $cat_array;
    }

    public function getCategoryById($id)
    {
        $stmt = $this->db->prepare("SELECT category FROM ".$this->tbl_category." WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function getAllAssignments()
    {
        $a_array = array();

        $stmt = $this->db->prepare("SELECT * FROM ".$this->tbl_assignment." ORDER BY `id`");
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            while ( $editRow = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                $a_array[$editRow['id']] = $editRow['assignment'];
            }
        }

        return $a_array;
    }

    public function getAssignmentById($id)
    {
        $stmt = $this->db->prepare("SELECT assignment FROM ".$this->tbl_assignment." WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function getAssignmentNamebyID($id) {
        return ($this->getAssignmentById($id))["assignment"];
    }

    public function getShiftEntry($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->tbl_shift_entry . " WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function printRnShiftTable($days_to_print = 5, $offset = 0)
    {
    //Likely need to make a very complex table print of shift entries here
    //
    //         | date 1 | date 2 | date 3 | Single letter denoting the most important identifier
    //  name 1 |   v    |   S    |   A    |   Cn => Clinician, Ch => Charge, O => Outreach, D => doubled, S => very sick, A => admit,
    //  name 2 |   D    |   N    |   N    |   N => Non-vented, V => vented
    //  name 3 |   -    |   -    |   D    |
    //
    //  First, determine the role id for NA / UC
    //  Then, Select the table values that are NOT NA/UC
    //  Then, left join the staff to the shift entry
    //  Then, left join the assignment to the shift entry
    //  Then, left join the role to the shift entry
    //  Then, order by the staff, then date
    //
    //SELECT tbl_shift_entry.shift_date AS shift_date,
    //  CONCAT(tbl_staff.last_name, ", ", tbl_staff.first_name) AS name,
    //  tbl_staff_roles.role AS role,
    //  tbl_assignments.assignment AS assignment,
    //  tbl_shift_entry.bool_doubled AS doubled,
    //  tbl_shift_entry.bool_vented AS doubled,
    //  tbl_shift_entry.bool_new_admit AS new_admit,
    //  tbl_shift_entry.bool_very_sick AS very_sick,
    //  tbl_shift_entry.bool_code_pager AS code_pager,
    //  tbl_shift_entry.bool_day_or_night AS day_or_night
    //  FROM tbl_shift_entry
    //  LEFT JOIN `tbl_staff` ON tbl_shift_entry.staff_id = tbl_staff.id
    //  LEFT JOIN `tbl_assignments` ON tbl_shift_entry.assignment_id = tbl_assignments.id
    //  LEFT JOIN `tbl_staff_roles` ON tbl_shift_entry.role_id = tbl_staff_roles.id
    //  WHERE tbl_shift_entry.role_id <> (SELECT id FROM tbl_staff_roles WHERE role='NA') AND tbl_shift_entry.role_id <> (SELECT id FROM tbl_staff_roles WHERE role='UC')

        $stmtShiftEntries = $this->db->prepare('SELECT
                                        '. $this->tbl_shift_entry .'.id AS `ID`,
                                        CONCAT('.$this->tbl_staff.'.last_name, ", ", '.$this->tbl_staff.'.first_name) AS `Staff`,
                                        '.$this->tbl_shift_entry.'.shift_date AS `Shift Date`,
                                        '.$this->tbl_role.'.role AS `Role`,
                                        '.$this->tbl_assignment.'.assignment AS `Assignment`,
                                        '.$this->tbl_shift_entry.'.bool_doubled AS `Double`,
                                        '.$this->tbl_shift_entry.'.bool_vented AS `Vented`,
                                        '.$this->tbl_shift_entry.'.bool_new_admit AS `Admit`,
                                        '.$this->tbl_shift_entry.'.bool_very_sick AS `Very Sick`,
                                        '.$this->tbl_shift_entry.'.bool_code_pager AS `Code Pager`,
                                        '.$this->tbl_shift_entry.'.bool_day_or_night AS `Day/Night`
                                    FROM
                                        '.$this->tbl_shift_entry.'
                                    LEFT JOIN
                                        '.$this->tbl_staff.' ON '.$this->tbl_shift_entry.'.staff_id = '.$this->tbl_staff.'.id
                                    LEFT JOIN
                                        '.$this->tbl_assignment.' ON '.$this->tbl_shift_entry.'.assignment_id = '.$this->tbl_assignment.'.id
                                    LEFT JOIN
                                        '.$this->tbl_role.' ON '.$this->tbl_shift_entry.'.role_id = '.$this->tbl_role.'.id
                                    LEFT JOIN
                                        '.$this->tbl_category.' ON '.$this->tbl_staff.'.category = '.$this->tbl_category.'.id
                                    INNER JOIN
                                        (SELECT DISTINCT shift_date FROM '.$this->tbl_shift_entry.' ORDER BY shift_date DESC LIMIT '.$days_to_print.' OFFSET '.$offset.') AS t2 ON t2.shift_date = '.$this->tbl_shift_entry.'.shift_date
                                    WHERE
                                        '.$this->tbl_category.'.category = "RN"
                                    ORDER BY `Staff`');

        $stmtShiftEntries->execute();

        //  In php, create a 3-dimensional array shift_array[Staff Name][Shift Date][Letter Code]
        if ($stmtShiftEntries->rowCount()>0) {
            while ($row=$stmtShiftEntries->fetch(PDO::FETCH_ASSOC)) {
                $letter_code = '-';

                // C => Clinician, P => Prn Charge, O => Outreach, D => doubled, S => very sick, A => admit, N => Non-vented, V => vented, F => undefined
                if (strpos($row['Role'], 'Clinician') !== false) {
                    $letter_code = 'C';
                } elseif (strpos($row['Role'], 'Charge') !== false) {
                    $letter_code = 'P';
                } elseif (strpos($row['Role'], 'Outreach') !== false) {
                    $letter_code = 'O';
                } elseif ($row['Double'] == 1) {
                    $letter_code = 'D';
                } elseif ($row['Very Sick'] == 1) {
                    $letter_code = 'S';
                } elseif ($row['Admit'] == 1) {
                    $letter_code = 'A';
                } elseif ($row['Vented'] == 0) {
                    $letter_code = 'N';
                } elseif ($row['Vented'] == 1) {
                    $letter_code = 'V';
                } else {
                    $letter_code = 'F';
                }

                $staff_shifts_array[ $row['Staff'] ][ $row['Shift Date'] ] = '<a href="javascript:void(0);" data-shift-entry-id="'.$row['ID'].'" data-shift-entry-letter="'.$letter_code.'">'.$letter_code.'</a>';
            }
        } else {
            die("No Shifts Entered");
        }

        $stmtCountUniqueDates = $this->db->prepare('SELECT COUNT(DISTINCT shift_date) FROM '.$this->tbl_shift_entry.' LIMIT '.$days_to_print.' OFFSET '.$offset);
        $stmtCountUniqueDates->execute();
        $countUniqueDates = $stmtCountUniqueDates->fetch(PDO::FETCH_ASSOC);

        $stmtUniqueDates = $this->db->prepare('SELECT DISTINCT shift_date FROM '.$this->tbl_shift_entry.' ORDER BY shift_date DESC LIMIT '.$days_to_print.' OFFSET '.$offset);
        $stmtUniqueDates->execute();

        $shift_dates_array = array();
        if ($stmtUniqueDates->rowCount()>0) {
            while ($row=$stmtUniqueDates->fetch(PDO::FETCH_ASSOC)) {
                array_unshift($shift_dates_array, $row['shift_date']);
            }
        }

        //loop to generate date header
        //also generate rows with staff entries
        //
        //Effect should be something like:
        //
        //              |Jul                          |Aug
        //              |1    |2    |3    |4    |5    |1    |2    |3    |4    |
        //       name 1 |  -  |  C  |  C  |  C  |  C  |  -  |  -  |  -  |  -  |
        //       name 2 |  -  |  -  |  -  |  V  |  V  |  -  |  -  |  -  |  -  |
        //       name 3 |  -  |  -  |  S  |  S  |  S  |  -  |  -  |  -  |  O  |
        //

        $date_month_header = '';
        $date_date_header = '';
        $month = '';
        $staff_shifts_table_rows = array();

        foreach ( $shift_dates_array as $v ) {
            $prev_month = $month;

            $date = DateTime::createFromFormat('Y-m-d', $v);

            $month = $date->format('M');

            if ($month !== $prev_month) {
                $date_month_header = $date_month_header . '<th class="shift-cell">' . $month . "</th>";
            } else {
                $date_month_header = $date_month_header . '<th class="shift-cell">&nbsp;</th>';
            }

            $date_date_header = $date_date_header . '<th class="shift-cell">' . $date->format('d') . '</th>';

            //for each date, test against the staff shifts multidimensional array
            //  if the sub-array has the date set then set the letter code in the table else, put a dash
            $shift_counter = 0;
            foreach ($staff_shifts_array as $l => $w) {

                if (!isset($staff_shifts_table_rows[$shift_counter])){
                    $staff_shifts_table_rows[$shift_counter] = '';
                }

                if ( isset($w[$v]) ) {
                    $staff_shifts_table_rows[$shift_counter] = $staff_shifts_table_rows[$shift_counter] . '<td class="shift-cell">' . $staff_shifts_array[$l][$v] . '</td>';
                } else {
                    $staff_shifts_table_rows[$shift_counter] = $staff_shifts_table_rows[$shift_counter] . '<td class="shift-cell">-</td>';
                }

                $shift_counter = $shift_counter + 1;
            }
        }


        echo "      <div class=\"shift-table-div\">\r\n";
        echo "        <table class=\"table table-hover table-responsive table-striped table-sm shift-table\">\r\n";
        echo "          <thead>\r\n";
        echo "            <tr>\r\n";
        echo "              <th class=\"shift-row-head\">&nbsp;</th>" . $date_month_header . "\r\n";
        echo "            </tr>\r\n";
        echo "            <tr class=\"table-inverse\">\r\n";
        echo "              <th class=\"shift-row-head\">Date</th>" . $date_date_header . "\r\n";
        echo "            </tr>\r\n";
        echo "          </thead>\r\n";
        echo "          <tbody>\r\n";

        //loop to generate chart goes here
        $x = 0;
        foreach ( $staff_shifts_array as $k => $v) {
            echo "            <tr>\r\n";
            echo "              <th class=\"shift-row-head\" scope=\"row\"><pre>".$k."</pre></th>".$staff_shifts_table_rows[$x];
            echo "            </tr>\r\n";
            $x++;
        }

        echo "          </tbody>\r\n";
        echo "        </table>\r\n";
        echo "      </div>\r\n";
    }

    public function printShiftEntry($shift_id) {
        if ($shift_id < 0) {
            throw new Exception('`Shift ID` parameter must be an integer greater than 0.');
        }

        $entry = $this->getShiftEntry($shift_id);
        $entry_staff_name = $this->getStaffById($entry['staff_id']);
        $entry_assignment = $this->getAssignmentNamebyID($entry['assignment_id']);
        $entry_role = $this->getRoleNameById($entry['role_id']);

        //var_dump($entry);
        //var_dump($entry_staff_name);
        //var_dump($entry_assignment);
        //var_dump($entry_role);


        echo "    <p>Staff: " . $entry_staff_name['first_name'] . ' ' . $entry_staff_name['last_name'] . ', ' . $entry_staff_name['category'] . "</p>\r\n";
        echo "    <p>Date: " . DateTime::createFromFormat('Y-m-d', $entry['shift_date'])->format('F j, Y') . ' -- ' . (($entry['bool_day_or_night']) ? 'Night' : 'Day') . " Shift</p>\r\n";
        echo "    <p>Role: " . $entry_role . "</p>\r\n";
        echo "    <p>Pod Assignment: " . $entry_assignment .  "</p>\r\n";
        echo "    <p>Vented? " . (($entry['bool_vented']) ? 'Vented' : 'Non-vented') . "</p>\r\n";
        echo "    <p>Doubled? " . (($entry['bool_doubled']) ? 'Yes' : 'No') . "</p>\r\n";
        echo "    <p>Very Sick? " . (($entry['bool_very_sick']) ? 'Yes' : 'No') . "</p>\r\n";
        echo "    <p>Admitted? " . (($entry['bool_new_admit']) ? 'Yes' : 'No') . "</p>\r\n";
        echo "    <p>Code pager? ". (($entry['bool_code_pager']) ? 'Yes' : 'No') . "</p>\r\n";
    }


    /*
     * CRUD --
     * Update FUNCTIONS
     * STAFF, ROLE, CATEGORY, ASSIGNMENT SHIFT ENTRY
     */

    public function updateStaff($id, $f_name, $l_name, $id_category, $is_active)
    {
        try {
            $stmt = $this->db->prepare("UPDATE ".$this->tbl_staff." SET first_name=:fname, last_name=:lname, category=:cid, bool_is_active=:ia WHERE id=:id ");
            $stmt->bindparam(":fname", $f_name);
            $stmt->bindparam(":lname", $l_name);
            $stmt->bindparam(":cid", $id_category);
            $stmt->bindparam(":ia", $is_active);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateStaffToActive($id)
    {
        try {
            $stmt = $this->db->prepare("UPDATE ".$this->tbl_staff." SET bool_is_active=:bis WHERE id=:id ");
            $stmt->bindparam(":ia", 1);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateStaffToInactive($id)
    {
        try {
            $stmt = $this->db->prepare("UPDATE ".$this->tbl_staff." SET bool_is_active=:bis WHERE id=:id ");
            $stmt->bindparam(":ia", 0);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateRole($id, $r_name)
    {
        try {
            $stmt = $this->db->prepare("UPDATE ".$this->tbl_role." SET role=:rn WHERE id=:id");
            $stmt->bindparam(":rn", $r_name);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateCategory($id, $c_name)
    {
        try {
            $stmt = $this->db->prepare("UPDATE ".$this->tbl_category." SET category=:cn WHERE id=:id");
            $stmt->bindparam(":cn", $c_name);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateAssignment($id, $a_name)
    {
        try {
            $stmt = $this->db->prepare("UPDATE ".$this->tbl_assignment." SET assignement=:an WHERE id=:id");
            $stmt->bindparam(":an", $a_name);
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateShiftEntry($id, $shift_date, $staff_id, $role_id, $assignment_id, $bool_doubled, $bool_vented, $bool_new_admit, $bool_very_sick, $bool_code_pager, $bool_day_or_night)
    {
        try {
            $stmt = $this->db->prepare("UPDATE ".$this->tbl_shift_entry." SET shift_date=:date, staff_id=:sid, role_id=:rid, assignment_id=:aid, bool_doubled=:bd, bool_vented=:bv, bool_new_admit=:bna, bool_very_sick=:bvs, bool_code_pager=:bcp, bool_day_or_night=:bdon WHERE id=:id");
            $stmt->bindparam(":date", $shift_date);
            $stmt->bindparam(":sid", $staff_id);
            $stmt->bindparam(":rid", $role_id);
            $stmt->bindparam(":aid", $assignment_id);
            $stmt->bindparam(":bd", boolean_to_int($bool_doubled));
            $stmt->bindparam(":bv", boolean_to_int($bool_vented));
            $stmt->bindparam(":bna", boolean_to_int($bool_new_admit));
            $stmt->bindparam(":bvs", boolean_to_int($bool_very_sick));
            $stmt->bindparam(":bcp", boolean_to_int($bool_code_pager));
            $stmt->bindparam(":bdon", boolean_to_int($bool_day_or_night));
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateNaShiftEntry($shift_date, $staff_id, $assignment_id, $bool_day_or_night)
    {
        try {
            $role_id = $this->db->query("SELECT id FROM ".$this->tbl_role." WHERE role='NA'");

            $stmt = $this->db->prepare("UPDATE ".$this->tbl_shift_entry." SET shift_date=:date, staff_id=:sid, role_id=:rid, assignment_id=:aid, bool_day_or_night=:bdon WHERE id=:id");

            $stmt->bindparam(":date", $shift_date);
            $stmt->bindparam(":sid", $staff_id);
            $stmt->bindparam(":rid", $role_id);
            $stmt->bindparam(":aid", $assignment_id);
            $stmt->bindparam(":bdon", boolean_to_int($bool_day_or_night));
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateUcShiftEntry($shift_date, $staff_id, $assignment_id, $bool_day_or_night)
    {
        try {
            $role_id = $this->db->query("SELECT id FROM ".$this->tbl_role." WHERE role='UC'");

            $stmt = $this->db->prepare("UPDATE ".$this->tbl_shift_entry." SET shift_date=:date, staff_id=:sid, role_id=:rid, assignment_id=:aid, bool_day_or_night=:bdon WHERE id=:id");

            $stmt->bindparam(":date", $shift_date);
            $stmt->bindparam(":sid", $staff_id);
            $stmt->bindparam(":rid", $role_id);
            $stmt->bindparam(":aid", $assignment_id);
            $stmt->bindparam(":bdon", boolean_to_int($bool_day_or_night));
            $stmt->bindparam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /*
     * CRUD --
     * Update FUNCTIONS
     * STAFF, ROLE, CATEGORY, ASSIGNMENT SHIFT ENTRY
     */

    public function deleteStaff($id)
    {
        $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_staff." WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        return true;
    }

    public function deleteRole($id)
    {
        $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_role." WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        return true;
    }

    public function deleteCategoy($id)
    {
        $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_category." WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        return true;
    }

    public function deleteAssignment($id)
    {
        $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_assignment." WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        return true;
    }

    public function deleteShiftEntry($id)
    {
        $stmt = $this->db->prepare("DELETE FROM ".$this->tbl_shift_entry." WHERE id=:id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        return true;
    }

 /* paging

    public function dataview($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                <td><?php print($row['id']); ?></td>
                <td><?php print($row['first_name']); ?></td>
                <td><?php print($row['last_name']); ?></td>
                <td><?php print($row['email_id']); ?></td>
                <td><?php print($row['contact_no']); ?></td>
                <td align="center">
                <a href="edit-data.php?edit_id=<?php print($row['id']); ?>"><i class="glyphicon glyphicon-edit"></i></a>
                </td>
                <td align="center">
                <a href="delete.php?delete_id=<?php print($row['id']); ?>"><i class="glyphicon glyphicon-remove-circle"></i></a>
                </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
        }
    }

    public function paging($query, $records_per_page)
    {

        $starting_position=0;
        if (isset($_GET["page_no"])) {
            $starting_position=($_GET["page_no"]-1)*$records_per_page;
        }

        $query2=$query." limit $starting_position,$records_per_page";
        return $query2;
    }

    public function paginglink($query, $records_per_page)
    {

        $self = $_SERVER['PHP_SELF'];

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $total_no_of_records = $stmt->rowCount();

        if ($total_no_of_records > 0) {
            ?><ul class="pagination"><?php
   $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
   $current_page=1;
if (isset($_GET["page_no"])) {
    $current_page=$_GET["page_no"];
}
if ($current_page!=1) {
    $previous =$current_page-1;
    echo "<li><a href='".$self."?page_no=1'>First</a></li>";
    echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
}
for ($i=1; $i<=$total_no_of_pages; $i++) {
    if ($i==$current_page) {
        echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
    } else {
        echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
    }
}
if ($current_page!=$total_no_of_pages) {
    $next=$current_page+1;
    echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
    echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
}
    ?></ul><?php
        }
    }

 paging */
}
