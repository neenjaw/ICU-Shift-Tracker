/*
 * This is a specialized function to create a table element for the ICU Shift Tracker web app
 * Assumptions:
 *    1. Bootstrap is the front-end style library in use.
 *    2. $dataArray is in the format specified as a JSON object:
 *
 *    {
 *          staff: {
 *              name : "Name",
 *              id : int,
 *              shifts: [
 *                  {shift_date: "yyyy-mm-dd", shift_id: int, shift_code: char(1)},
 *                  {shift_date: "yyyy-mm-dd", shift_id: int, shift_code: char(1)},
 *                  ...
 *              ]
 *          },
 *          staff: {
 *              name : "Name",
 *              id : int,
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
function buildShiftTable(shiftDataJSON, shiftHeadClasses = '', shiftCellClasses = '', locale = 'en-us') {
  function buildShiftCell(doc, shift) {
    var c = doc.createElement("td");
    c.dataset.shiftDate = shift.shift_date;
    c.dataset.shiftId = shift.shift_id;
    c.dataset.shiftCode = shift.shift_code;

    c.innerHTML = shift.shift_code;

    return c;
  }

  function buildNameHeadCell(doc, staff) {
    var c = doc.createElement("td");
    c.dataset.staffName = staff.name;
    c.dataset.staffId = staff.id;

    c.innerHTML = staff.name;

    return c;
  }

  function buildMonthHeadCell(doc, date, lastDate, locale) {
    var c = doc.createElement("th");
    c.dataset.shiftDate = shift.shift_date;

    c.innerHTML = "m";

    return c;
  }

  function buildDateHeadCell(doc, date) {
    var c = doc.createElement("th");
    c.dataset.shiftDate = shift.shift_date;

    c.innerHTML = date.getDate();

    return c;
  }


  var doc = document;
  var shiftTable = doc.createElement("table");
  var headMonthFragment = doc.createDocumentFragment();
  var headDateFragment = doc.createDocumentFragment();
  var rowFragment = doc.createDocumentFragment();

  var firstLoop = true;
  var lastDate = new Date("0001-01-01");

  //for each loop through each of the staff entry of the JSON

  for (staff in shiftDataJSON) {
      // skip loop if the property is from prototype
      if (!shiftDataJSON.hasOwnProperty(staff)) continue;

      if (firstLoop) {
        //Create the first row
        headMonthFragment.appendChild(doc.createElement("tr"));

        var headMonthCell = doc.createElement("th");
        headMonthCell.innerHTML = '&nbsp;';

        headMonthFragment.appendChild(headMonthCell);

        //Create the second row
        headDateFragment.appendChild(doc.createElement("tr"));

        var headDateCell = doc.createElement("th");
        headDateCell.innerHTML = '&nbsp;';

        headDateFragment.appendChild(headDateCell);
      }

      rowFragment.appendChild(doc.createElement("tr"));

      var rowCell = doc.createElement("th");
      rowCell.innerHTML = shiftDataJSON[staff].name;

      rowFragment.appendChild(rowCell);

      //create each row for the table, with dynamic links as neccessary where char != '-'
          //in the first iteration, create the header rows
          //name in first column as a <th></th>, then every shift as a <td><td>
      //append it to the fragment
      for (shift in shiftDataJSON[staff].shifts) {
        // skip loop if the property is from prototype
        if (!shiftDataJSON[staff].shifts.hasOwnProperty(shift)) continue;

        var shiftId = shiftDataJSON[staff].shifts[shift].shift_id;
        var shiftDate = new Date(shiftDataJSON[staff].shifts[shift].shift_date);
        var shiftCode = shiftDataJSON[staff].shifts[shift].shift_code;

        if (firstLoop) {
          headMonthCell = doc.createElement("th");
          headMonthCell.dataset.shiftDate = shiftDate;

          if ( !( (lastDate.getYear() == shiftDate.getYear()) && (lastDate.getMonth() == shiftDate.getMonth()) ) ) {
            headMonthCell.innerHTML = shiftDate.toLocaleString(locale, { month: "short" });
          } else {
            headMonthCell.innerHTML = '';
          }

          headMonthFragment.appendChild(headMonthCell);

          headDateCell = doc.createElement("th");
          headDateCell.dataset.shiftDate = shiftDate;
          headDateCell.innerHTML = shiftDate.getDate();
        }
      }

      firstLoop = false;
  }
  //end loop

  //append the rows to the table dom object

  //return the completed table to caller so can be appended to dom at correct place.
  return shiftTable;
}
