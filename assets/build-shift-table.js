/*
 * This is a specialized function to create a table element for the ICU Shift Tracker web app
 * Assumptions:
 *    1. Bootstrap is the front-end style library in use.
 *    2. $dataArray is in the format specified as a JSON object:
 *
 *    {
 *          staff: {
 *              name : "Name",
 *              shifts: [
 *                  {shift_date: "yyyy-mm-dd", shift_id: int, shift_code: char(1)},
 *                  {shift_date: "yyyy-mm-dd", shift_id: int, shift_code: char(1)},
 *                  ...
 *              ]
 *          },
 *          staff: {
 *              name : "Name",
 *              shifts: [
 *                  {shift_date: "yyyy-mm-dd", shift_id: int, shift_code: char(1)},
 *                  {shift_date: "yyyy-mm-dd", shift_id: int, shift_code: char(1)},
 *                  ...
 *              ]
 *          }
 *    }
 *
 * Output:
 *
 *        |Jul                          |Aug
 *        |1    |2    |3    |4    |5    |1    |2    |3    |4    |
 * name 1 |  -  |  C  |  C  |  C  |  C  |  -  |  -  |  -  |  -  |
 * name 2 |  -  |  -  |  -  |  V  |  V  |  -  |  -  |  -  |  -  |
 * name 3 |  -  |  -  |  S  |  S  |  S  |  -  |  -  |  -  |  O  |
 *
 */
function buildShiftTable($dataArray, $shiftHeadClasses = '', $shiftCellClasses = '') {
  var doc = document;
  var shiftTable = doc.createElement("table");
  var fragment = doc.createDocumentFragment();

  //for each loop through each of the staff entry of the JSON
      //in the first iteration, create the header rows
      //create each row for the table, with dynamic links as neccessary where char != '-'
          //name in first column as a <th></th>, then every shift as a <td><td>
      //append it to the fragment
  //end loop

  //append the rows to the table dom object

  //return the completed table to caller so can be appended to dom at correct place.
  return shiftTable;
}

/*
(EX)

var doc = document;

var fragment = doc.createDocumentFragment();

for (i = 0; i < 3; i++) {
    var tr = doc.createElement("tr");

    var td = doc.createElement("td");
    td.innerHTML = "content";

    tr.appendChild(td);

    //does not trigger reflow
    fragment.appendChild(tr);
}

var table = doc.createElement("table");

table.appendChild(fragment);

doc.getElementById("here_table").appendChild(table);
*/
