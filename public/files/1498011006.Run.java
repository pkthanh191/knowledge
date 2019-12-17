package cnf;

import java.util.ArrayList;
import java.util.Scanner;
import java.util.Stack;

import cky.CKY;

public class Run {
	public static void main(String[] args) {
		VanPham v = new VanPham("input2.txt");
		v.epsilon = "e";
//		System.out.println(v.rules.size());
//		for (Rule rule : v.rules) {
//			System.out.println("Ve phai: "+rule.right);
//		}
//		v.deleteRuleMeaningless();
//		System.out.println("Luat Moi");
//		for (Rule rule : v.rules) {
//			System.out.println(rule.toString());
//		}
//		System.out.println(v.getInvolveAnphabelPhu());
//		v.deleteRuleMeaningless();
//		System.out.println("Luat Moi");
//		for (Rule rule : v.rules) {
//			System.out.println(rule.toString());
//		}
//		System.out.println("Make Epsilon");
//		System.out.println(v.createEpsilon(v.epsilon));
//		v.deleteEpsilon();
//
//		System.out.println("Luat Moi");
//		for (Rule rule : v.rules) {
//			System.out.println(rule.toString());
//		}
//
//		v.deleteRuleSingle();
//		System.out.println("Luat Moi");
//		for (Rule rule : v.rules) {
//			System.out.println(rule.toString());
//		}
//
//		v.diviveRules();
//		System.out.println("Rule chinh");
//		for (Rule rule : v.rulesContrainMain) {
//			System.out.println(rule.toString());
//		}
//		System.out.println("Rule phu");
//		for (Rule rule : v.rulesConTrainPhu) {
//			System.out.println(rule.toString());
//		}
//
//		// CYK cyk = new CYK("aabbbb");
//		// cyk.setUpAllMatrix(v.rulesContrainMain, v.rulesConTrainPhu);
//		// System.out.println(cyk.matrix.length);
//		// cyk.showMatrix();
//		System.out.println("-----------------------------------");
//		// cyk.setUpMatrix("S", "bb");
//		// cyk.showMatrix();
//
//		// v.cky("abab");
//
//		Stack<Character> stack = new Stack<>();
//		for (int i = 65; i <= 90; i++) {
//			if (v.alphabetPhu.indexOf((char) i + "") == -1)
//				stack.push((char) i);
//		}
//		v.finalStep(v.rulesContrainMain, v.rulesConTrainPhu, stack);
//
//		System.out.println("Rule chinh");
//		for (Rule rule : v.rulesContrainMain) {
//			System.out.println(rule.toString());
//		}
//		System.out.println("Rule phu");
//		for (Rule rule : v.rulesConTrainPhu) {
//			System.out.println(rule.toString());
//		}
//		v.convertToCNF();
//		v.cky("abab");
		Scanner scan = new Scanner(System.in);
		System.out.println("Nhap xau kiem tra");
		String s = scan.nextLine();
		v.cky(s);
		
	}

}
