function buildShiftTable(stafflist, args) {
  //load options, supplied or default
  let options = args || {};
  options.tableId = args.tableId || 'shift-table';
  options.tableClasses = args.tableClasses || '';
  options.theadClasses = args.theadClasses || '';
  options.tbodyClasses = args.tbodyClasses || '';
  options.dheadClasses = args.dheadClasses || '';
  options.rheadClasses = args.rheadClasses || '';
  options.staffDividerClasses = args.staffDividerClasses || '';
  options.cellClasses = args.cellClasses || '';
  options.locale = args.locale || 'en-us';
  options.staffOrder = args.staffOrder || ['RN', 'LPN', 'NA', 'UC'];

  if (debug) console.log(options);

  //divide the staff by category
  let staffByCategory = [];
  for (let i = 0; i < stafflist.length; i++) {
    //check if the array at this index exists, if not make a new array
    staffByCategory[stafflist[i].category] = staffByCategory[stafflist[i].category] || [];
    //push the staff member object to the array at the index
    staffByCategory[stafflist[i].category].push(stafflist[i]);
  }

  if (debug) console.log(staffByCategory);

  //make the table
  let $table = $(`<table></table>`).addClass(options.tableClasses).attr('id', options.tableId);

  //make the first two rows of the right table
  let $tMonthHead = $(`<tr></tr>`).addClass(options.dheadClasses);
  $tMonthHead.append($(`<th>Month</th>`));
  let $tDateHead = $(`<tr></tr>`).addClass(options.dheadClasses);
  $tDateHead.append($(`<th>Date</th>`));

  //build the first two rows of the left table
  $table.append(
    $(`<thead></thead>`)
      .append($tMonthHead)
      .append($tDateHead)
      .addClass(options.theadClasses)
    );

  //build the table's body, keep reference to it for the loop
  let $tbody = $(`<tbody></tbody>`);
  $table.append($tbody);

  //loop through the staff categories in order
  for (let i = 0; i < options.staffOrder.length; i++) {
    let c = options.staffOrder[i];

    //if the category is in the list of staff, build the table for that category
    if (c in staffByCategory) {
      let $cRow = $(`<tr></tr>`)
                    .append($(`<th>${c}</th>`))
                    .addClass(options.rheadClasses)
                    .addClass(options.staffDividerClasses);

      //first row for each category, make a light weight header
      $tbody.append($cRow);

      //for each staff member, build a row for them
      for (let j = 0; j < staffByCategory[c].length; j++) {
        let s = staffByCategory[c][j];

        $sRow = $(`<tr></tr>`);
        $tbody.append($sRow);

        $sRow.append($(`<td></td>`)
                       .addClass(options.rheadClasses)
                       .attr('data-staff-name', s.name)
                       .attr('data-staff-id', s.id)
                       .append(
                         $(`<pre>${s.name}</pre>`)
                       ));

        for (let k = 0, prevDate = new Date("0001-01-01"); k < s.shifts.length; k++) {
          let shift = s.shifts[k];

          //on the first iteration of the category loop, build the month/date rows
          if ((i === 0) && (j === 0)) {
            let date = new Date(shift.date);
            let month = '&nbsp;';

            //if it is a new month, then set the print the month, set cursor to current date
            if ( (date.getUTCFullYear() > prevDate.getUTCFullYear()) ||
                 ((date.getUTCFullYear() === prevDate.getUTCFullYear()) && (date.getUTCMonth() > prevDate.getUTCMonth())) ) {

              month = date.toLocaleString(options.locale, { month: "short", timeZone: 'UTC' });
              prevDate = date;
            }

            $tMonthHead.append($(`<th>${month}</th>`));

            $tDateHead.append($(`<th>${date.getUTCDate()}</th>`));
          }

          //on the first iteration of the staff loop, build the new category row
          if (j === 0) {
            $cRow.append($(`<td>&nbsp;</td>`));
          }

          //build the row of shifts for the row
          if (shift.code !== '-') {
            $sCell = $(`<a href="javascript:void(0)">${shift.code}</a>`);
          } else {
            $sCell = shift.code
          }

          $sRow.append($(`<td></td>`)
                         .addClass(options.cellClasses)
                         .attr('data-shift-id', shift.id)
                         .append($sCell));
        }
      }
    }
  }

  if (debug) console.log($table);

  return $table;
}
