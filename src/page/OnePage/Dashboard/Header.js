import React from 'react';
import PropTypes from 'prop-types';
import clsx from 'clsx';
import { makeStyles } from '@material-ui/styles';
import { Typography } from '@material-ui/core';
import { useSelector } from 'react-redux';

const useStyles = makeStyles(theme => ({
  root: {},
  dates: {
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'flex-end'
  },
  startDateButton: {
    marginRight: theme.spacing(1)
  },
  endDateButton: {
    marginLeft: theme.spacing(1)
  },
  calendarTodayIcon: {
    marginRight: theme.spacing(1)
  }
}));

const Header = props => {
  const { className, ...rest } = props;

  const classes = useStyles();

  const user = useSelector(state => state.user);

  return (
    <div
      {...rest}
      className={clsx(classes.root, className)}
    >
      <Typography
        component="h2"
        gutterBottom
        variant="overline"
      >
        Home
      </Typography>
      <Typography
        component="h1"
        gutterBottom
        variant="h3"
      >
        Welcome back {user.last_name + ' ' + user.first_name},
      </Typography>
      <Typography variant="subtitle1">Here's what's happening</Typography>
    </div>
  );
};

Header.propTypes = {
  className: PropTypes.string
};

Header.defaultProps = {};

export default Header;
