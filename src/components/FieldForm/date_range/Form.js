import { Typography } from "@material-ui/core";
import TextField from "@material-ui/core/TextField";
import { DateRangeDelimiter, DateRangePicker, LocalizationProvider } from "@material-ui/pickers";
import DateFnsUtils from "@material-ui/pickers/adapter/date-fns";
import React from 'react';
import { dateFormat } from "utils/helper";

export default function DatePickerForm(props) {

    const { config, post, onReview, name, inputProp, onOpen = false, ...rest } = props;

    let valueInital = (post && config.names && post[config.names[0]] && post[config.names[1]]) ? [new Date(post[config.names[0]]), new Date(post[config.names[1]])] : [
        null,
        null,
    ];
    // const [value, setValue] = React.useState(valueInital);

    const compareDate = (dateStart, dateEnd) => {

        if (!(dateStart instanceof Date) || !(dateEnd instanceof Date)) {
            return false;
        }

        if (dateStart.getTime() > dateEnd.getTime()) {
            return false;
        }

        return true;
    }

    const [openDataPicker, setOpenDataPicker] = React.useState(false);

    const [render, setRender] = React.useState(0);

    const onClosePicker = (e) => {
        setOpenDataPicker(false);
    }

    const onAccept = (newValue) => {

        if (!compareDate(newValue[0], newValue[1])) {
            newValue.reverse();
        }

        post[config.names[0]] = dateFormat(newValue[0]);
        post[config.names[1]] = dateFormat(newValue[1]);

        onReview(null, {
            [config.names[0]]: dateFormat(newValue[0]),
            [config.names[1]]: dateFormat(newValue[1])
        });

        setRender(render + 1);
    }

    console.log('render DATE RANGE');

    return (
        <LocalizationProvider dateAdapter={DateFnsUtils}>
            <Typography variant="body1" style={{ marginBottom: 16 }}>{config.title}</Typography>
            <DateRangePicker
                startText={config.startDateLabel ?? "Start Date"}
                endText={config.endDateLabel ?? "End Date"}
                disableCloseOnSelect={false}
                disableAutoMonthSwitching
                value={valueInital}
                open={openDataPicker !== false}
                onClose={onClosePicker}
                onAccept={onAccept}
                onChange={() => {

                }}
                renderInput={(startProps, endProps) => (
                    <div style={{ width: '100%', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                        <TextField onClick={() => { if (onOpen) onOpen(); setOpenDataPicker(0); }} style={{ width: '100%' }} {...startProps} />
                        <DateRangeDelimiter style={{ marginBottom: 13 }}> to </DateRangeDelimiter>
                        <TextField onClick={() => { if (onOpen) onOpen(); setOpenDataPicker(1) }} style={{ width: '100%' }} {...endProps} />
                    </div>
                )}
                {...rest}
            />
        </LocalizationProvider>
    );
}
