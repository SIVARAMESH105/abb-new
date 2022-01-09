$camp_details = DB::table("tbl_camp")
            ->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->join("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->select("tbl_camp.*", DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %d, %Y') as startCamp"),DB::raw("DATE_FORMAT(tbl_camp.enddate, '%M %d, %Y') as endCamp"), "tbllocation.*", "tbl_state_codes.state_id", "tbl_state_codes.state_name")
			->where([
			    ["tbl_state_codes.state_id", "=", $_GET['stateId']],
			    ["tbllocation.City", "=", $_GET['cityId']],
			])
			->whereRaw("date_format(tbl_camp.startdate, '%Y-%m') = date_format('$date', '%Y-%m')")
			->whereDate('tbl_camp.startdate', '>', Carbon::now())
            ->get();



SELECT * FROM `tbl_cms_content` where content LIKE '%Industry%'

SELECT *
FROM tbl_camp
INNER JOIN tbllocation ON tbl_camp.LocationId=tbllocation.Id  inner join tbl_state_codes  on 
tbl_state_codes.state_code = tbllocation.state  where tbllocation.City  LIKE '%Portland%  AND tbl_state_codes.state_code LIKE 'AL';




SELECT *
FROM tbl_camp
INNER JOIN tbllocation ON tbl_camp.LocationId=tbllocation.Id  where tbllocation.City  LIKE '%Portland%'' ;

SELECT *
FROM tbl_camp
INNER JOIN tbllocation ON tbl_camp.LocationId=tbllocation.Id  inner join tbl_state_codes  on 
tbl_state_codes.state_id = tbllocation.State  where tbllocation.City  LIKE '%Portland%'  AND tbl_state_codes.state_code LIKE 'AL';


SELECT first_name, last_name, subject
FROM student_details
WHERE subject IN ('Maths', 'Science'); 


SELECT * FROM `tbl_camp` where LocationId ='56';