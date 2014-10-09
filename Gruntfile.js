module.exports = function(grunt) {

  grunt.initConfig({

    concat: {
      js: {
        src: [
          './bower_components/jquery/dist/jquery.js',
          './app/assets/js/*.min.js',
          './app/assets/js/*.js',   
          './app/assets/js/modules/*.js'    
        ],
        dest: './public/assets/js/application.js'
      }
    },
    cssmin: {
	  combine: {
	    files: {
	      './public/assets/css/application.css': ['./app/assets/css/*.css']
	    }
	  }
	},
    uglify: {
      options: {
        mangle: false
      },
      js: {
        files: {
          './public/assets/js/application.js':'./public/assets/js/application.js'
        }
      }
    },  
    watch: {
      js: {
        files: [
          './bower_components/jquery/dist/jquery.js',
          './app/assets/js/*.min.js',
          './app/assets/js/*.js',   
          './app/assets/js/modules/*.js' 
          ],
        tasks: ['concat:js', 'uglify:js', 'cssmin:combine']
      }
    }    
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['watch']); 
  grunt.registerTask('compile', ['concat:js','uglify:js','cssmin']);
}