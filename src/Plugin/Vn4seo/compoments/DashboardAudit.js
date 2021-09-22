import React from 'react';
import clsx from 'clsx';
import { makeStyles } from '@material-ui/styles';
import { Card, Typography } from '@material-ui/core';
import gradients from '../../../utils/gradients';
import CircularChart from './Measure/CircularChart';
import { Skeleton } from '@material-ui/lab';
import { Link } from 'react-router-dom';

const useStyles = makeStyles(theme => ({
  root: {
    padding: theme.spacing(3),
    alignItems: 'center',
    justifyContent: 'space-between',
    '--color-fast': '#0cce6b',
    '--color-average': '#ffa400',
    '--color-slow': '#ff4e42',
  },
  details: {
    display: 'flex',
    alignItems: 'center',
    flexWrap: 'wrap'
  },
  label: {
    marginLeft: theme.spacing(1)
  },
  avatar: {
    backgroundImage: gradients.green,
    height: 48,
    width: 48
  },
  scorescale: {
    display: 'inline-flex',
    padding: 8,
    border: '1px solid #e0e0e0',
    borderRadius: '20px',
    '& span': {
      display: 'inline-flex',
      margin: '0 12px',
      alignItems: 'center',
      '&::before': {
        content: '""',
        display: 'inline-block',
        height: 6,
        width: 16,
        background: 'var(--color)',
        marginRight: 8,
        borderRadius: 20,
      }
    }
  },
  link: {
    display: 'flex',
    justifyContent: 'center',
  }
}));

const DashboardAudit = props => {
  const { className, audit, keyAudit, title, score, linkDetail, width = 120, ...rest } = props;

  const classes = useStyles();

  return (
    <Card
      {...rest}
      className={clsx(classes.root, className)}
    >
      <Typography
        component="h3"
        gutterBottom
        variant="h4"
      >
        {title}
      </Typography>
      <div style={{ display: 'flex', justifyContent: 'space-around' }}>
        <div style={{ width: '100%' }}>
          <Link className={classes.link} to={keyAudit === 'best_practices' ? '/plugin/vn4seo/measure/best-practices?device=mobile' : ('/plugin/vn4seo/measure/' + keyAudit + '?device=mobile')}>
            {
              audit[keyAudit] ?
                <CircularChart width={width} scrore={audit[keyAudit].mobile} />
                :
                <Skeleton variant="circle" width={width} style={{ margin: '10px 0' }} animation="wave" height={width} />
            }
          </Link>
          <Typography
            component="h3"
            gutterBottom
            variant="overline"
            align="center"
          >
            Mobile
          </Typography>
        </div>
        <div style={{ width: '100%' }}>
          <Link className={classes.link} to={keyAudit === 'best_practices' ? '/plugin/vn4seo/measure/best-practices?device=desktop' : ('/plugin/vn4seo/measure/' + keyAudit + '?device=desktop')}>
            {
              audit[keyAudit] ?
                <CircularChart width={width} scrore={audit[keyAudit].desktop} />
                :
                <Skeleton variant="circle" width={width} style={{ margin: '10px 0' }} animation="wave" height={width} />
            }
          </Link>

          <Typography
            component="h3"
            gutterBottom
            variant="overline"
            align="center"
          >
            Desktop
          </Typography>
        </div>
      </div>
    </Card >
  );
};

export default DashboardAudit;
