import { FormControl, FormControlLabel, FormHelperText, FormLabel, Radio, RadioGroup, TextField } from '@material-ui/core'
import React from 'react'
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';

function DateTimeFormat(props) {
    const { config, name, post, onReview, ...rest } = props;

    const { ajax } = useAjax();

    const [value, setValue] = React.useState('');
    const [isCustom, setIsCustom] = React.useState(false);
    const [label, setLable] = React.useState('');

    React.useEffect(() => {
        setValue((post && post[name]) ? post[name] : '');
        setIsCustom(!(config.list_option && config.list_option[post[name]]));
        setLable(config.list_option && config.list_option[post[name]] ? config.list_option[post[name]] : '');
    }, [post]);

    const changeValue = (newValue, newIsCustom, newLabel) => {
        setValue(newValue);
        setIsCustom(newIsCustom);
        setLable(newLabel);
    };

    React.useEffect(() => {
        onReview(value);
    }, [value]);

    const changeValueCustom = e => {

        setValue(e.target.value);

        ajax({
            url: 'setting/get',
            method: 'POST',
            data: {
                renderDate: e.target.value
            },
            success: function (result) {
                changeValue(e.target.value, true, result.date);
            }
        });

        // e => changeValue(e.target.value, true)
    };

    return (
        <FormControl component="fieldset">
            <FormLabel component="legend">{config.title}</FormLabel>
            <RadioGroup aria-label={config.title} name={name} value={value} {...config}>
                {
                    config.list_option
                    && Object.keys(config.list_option).map(key =>
                        <FormControlLabel onClick={() => changeValue(key, false, config.list_option[key])} key={key} value={key} control={<Radio checked={value === key && !isCustom} color="primary" />} label={config.list_option[key]} />
                    )
                }
                <FormControlLabel style={{ whiteSpace: 'nowrap' }} onClick={() => changeValue(value, true, label)} value={value} control={<><Radio checked={isCustom} color="primary" />{__('Custom')}<TextField size="small" style={{ marginLeft: 8, marginRight: 8 }}
                    fullWidth
                    required
                    variant="outlined"
                    InputLabelProps={{
                        shrink: true,
                    }}
                    onChange={changeValueCustom}
                    name={name}
                    value={value}
                    label={config.title}
                    helperText={config.note}
                /> {label}</>} />
            </RadioGroup>
            <FormHelperText>{config.note}</FormHelperText>
        </FormControl>
    )
}

export default DateTimeFormat
