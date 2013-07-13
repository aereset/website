
var content="";

process.stdin.resume();
process.stdin.setEncoding('utf8');

process.stdin.on('data', function(chunk) {
	content = content + chunk;
});

process.stdin.on('end', function() {
	content = require("./wiki2html.js").wiki2html(content);
	console.log(content);
});
