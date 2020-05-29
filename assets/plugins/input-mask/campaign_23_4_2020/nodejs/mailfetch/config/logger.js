var winston = require('winston');
require('winston-daily-rotate-file');

var transport = new (winston.transports.DailyRotateFile)({
  filename: '/var/log/emailfetch/emailfetch.log',
  datePattern: 'YYYY-MM-DD',
  zippedArchive: true,
  maxSize: '20m',
  maxFiles: '14d'
});

transport.on('rotate', function (oldFilename, newFilename) {
  // do something fun
});

var logger = winston.createLogger({
  transports: [
    transport
  ]
});

module.exports = logger;