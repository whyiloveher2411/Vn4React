import { TextField, makeStyles } from '@material-ui/core'
import React from 'react'


const useStyles = makeStyles(() => ({
    editor: {
        '&>.MuiInputLabel-outlined.MuiInputLabel-shrink': {
            transform: 'translate(14px, -11px) scale(0.75)'
        },
        '&>.MuiInputBase-root>textarea, &>label': {
            lineHeight: 2.2
        }
    },
}))


export default React.memo( function JsonForm(props) {

    const { config, post, onReview, name, ...rest } = props;

    const classes = useStyles()

    const keyDownTab = e => {
        if (e.key === 'Tab') {
            e.preventDefault();
            let $this = e.currentTarget.querySelector('textarea');

            let start = $this.selectionStart;
            let end = $this.selectionEnd;

            $this.value = $this.value.substring(0, start) +
                "\t" + $this.value.substring(end);

            $this.selectionStart =
                $this.selectionEnd = start + 1;
        }
    };


    let valueInital = post && post[name] ? post[name] : '';

    try {
        if( post && post[name] ){
            valueInital = JSON.stringify( JSON.parse(post[name]) , null, "\t");
        }
    } catch (error) {
        valueInital = '';
    }

    const [value, setValue] = React.useState(0);

    console.log('render JSON');

    return (
        <TextField
            onKeyDown={keyDownTab}
            fullWidth
            required
            multiline
            variant="outlined"
            className={classes.editor}
            name={name}
            value={valueInital}
            label={config.title}
            helperText={config.note}
            {...rest}
            onBlur={e => { onReview(e.target.value) }}
            onChange={e => { setValue(value + 1); post[name] = e.target.value }}
        />
    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})
