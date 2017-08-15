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
function buildShiftTable(shiftDataJSON, shiftHeadClasses = '', shiftCellClasses = '') {
  var doc = document;
  var shiftTable = doc.createElement("table");
  var headMonthFragment = doc.createDocumentFragment();
  var headDateFragment = doc.createDocumentFragment();
  var rowFragment = doc.createDocumentFragment();
  var firstLoop = true;
  //for each loop through each of the staff entry of the JSON

  for (staff in shiftDataJSON) {
      // skip loop if the property is from prototype
      if (!shiftDataJSON.hasOwnProperty(key)) continue;

      if (firstLoop) {
        //Create the first row
        headMonthFragment.appendChild(doc.createElement("tr"));

        var headMonthCell = doc.createElement("th");
        headMonthCell.html('&nbsp;');

        headMonthFragment.appendChild(headMonthCell);

        //Create the second row
        headDateFragment.appendChild(doc.createElement("tr"));

        var headDateCell = doc.createElement("th");
        headDateCell.html('&nbsp;');

        headDateFragment.appendChild(headDateCell);
      }

      //create first column of row
      rowFragment.appendChild(doc.createElement("tr"));

      var rowCell = doc.createElement("th");
      rowCell.innerHTML = shiftDataJSON[staff].name;

      rowFragment.appendChild(rowCell);

      //create each row for the table, with dynamic links as neccessary where char != '-'
          //in the first iteration, create the header rows
          //name in first column as a <th></th>, then every shift as a <td><td>
      //append it to the fragment

      firstLoop = false;
  }
  //end loop

  //append the rows to the table dom object

  //return the completed table to caller so can be appended to dom at correct place.
  return shiftTable;
}
