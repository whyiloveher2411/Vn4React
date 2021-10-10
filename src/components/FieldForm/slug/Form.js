import TextField from '@material-ui/core/TextField';
import React from 'react';
import { __ } from 'utils/i18n';

export default React.memo(function TextForm(props) {
    const { config, post, onReview, name, ...rest } = props;

    let valueInital = post && post[name] ? post[name] : '';

    const [value, setValue] = React.useState(0);

    return (
        <TextField
            fullWidth
            variant="outlined"
            value={valueInital}
            label={config.title}
            helperText={config.note ?? __('Clean URLs, also sometimes referred to as RESTful URLs, user-friendly URLs, pretty URLs or search engine-friendly URLs')}
            {...rest}
            onBlur={e => { onReview(e.target.value) }}
            onChange={e => { setValue(value + 1); post[name] = e.target.value }}
        />
    )

}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})

