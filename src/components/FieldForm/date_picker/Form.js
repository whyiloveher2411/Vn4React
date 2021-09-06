import { FormControl, FormHelperText, TextField, Typography, makeStyles } from '@material-ui/core';
import { LocalizationProvider, MobileDateTimePicker, DatePicker, MobileDatePicker } from '@material-ui/pickers';
import DateFnsUtils from "@material-ui/pickers/adapter/date-fns";
import React from 'react';
import { dateTimeFormat } from 'utils/helper';


const useStyles = makeStyles((theme) => ({
    root: {
        '& .MuiPickersToolbar-dateTitleContainer .MuiTypography-h4': {
            color: theme.palette.primary.contrastText
        }
    },
}))

export default React.memo(function DatePickerForm(props) {
    const { config, post, onReview, name, ...rest } = props;

    let valueInital = (post && post[name]) ? (post[name] instanceof Date ? post[name] : new Date(post[name])) : new Date;

    const classes = useStyles();

    const [openDataPicker, setOpenDataPicker] = React.useState(rest.open);
    const [render, setRender] = React.useState(0);
    const onChange = (value) => {
        let valueTemp = dateTimeFormat(value);
        post[name] = valueTemp;
        onReview(valueTemp, name);
        setRender(prev => prev + 1);
    };

    console.log('render DATETIME');

    return (
        <FormControl fullWidth variant="outlined">
            <LocalizationProvider dateAdapter={DateFnsUtils}>
                <MobileDatePicker
                    clearable
                    ampm={true}
                    variant="dialog"
                    value={valueInital}
                    className={classes.root}
                    label={config.title}
                    renderInput={(params) => <TextField {...params} onClick={() => setOpenDataPicker(true)} variant="outlined" />}
                    open={openDataPicker}
                    InputAdornmentProps={{ position: "end" }}
                    onAccept={onChange}
                    onChange={onChange}
                    onClose={() => { setOpenDataPicker(true) }}
                    {...rest}
                />
            </LocalizationProvider>
            <FormHelperText><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
        </FormControl>
    )

}, (props1, props2) => {

    if (props1.post[props1.name] === props2.post[props2.name]) {

        if (props1.open === props2.open) {
            return true;
        }

    }

    return false;
})

